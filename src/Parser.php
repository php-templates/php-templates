<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;
use DomDocument\PhpTemplates\Facades\DomHolder;
//use DomDocument\PhpTemplates\Template;
//use DomDocument\PhpTeplates\Parsable;

class Parser
{
    private $document;
    private $codebuffer;
    
    private $tobereplaced = [
        '="__empty__"' => '',
    ];
    private $toberemoved = [];
    
    protected static $depth = -1;

    public function __construct(Document $doc, CodeBuffer $buffer)
    {
        $this->document = $doc;
        $this->codebuffer = $buffer;
    }

    public function parse($dom, $trimHtml = false)
    {
        // anything that is not DOMDocument will be scoped to avoid insertbefore.after situations reference confusion
        if ($dom->nodeName !== '#document' && $dom->nodeName !== '#text') {
            $temp = new HTML5DOMDocument;
            //$body = $temp->createnode('body');
            //$temp->childNodes->item(0)->appendChild();
            //$temp->removeChild($temp->childNodes->item(0));
            $dom = $temp->importNode($dom, true);
            $temp->appendChild($dom);//dom($temp, 33);die();
            $dom = $temp;
        }//dom($dom);
//d('parsing');dom($dom);
        self::$depth++;
        echo str_pad('', self::$depth+1, 'I').'<div style="border:1px solid gray;margin-left:'.(self::$depth*30).'px">';
        buf($this, 'starting from', self::$depth);
        dom($dom, 'parsing on depth '.self::$depth, self::$depth);
        $this->parseNode($dom);

        while ($this->toberemoved) {
            $node = array_pop($this->toberemoved);
                //echo 'removing'; dom($node);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }
        
        if ($trimHtml && $dom->nodeName !== '#text') {
            //dom($dom, 123);
            $htmlString = DomHolder::trimHtml($dom);
        } /*
        elseif (isset($temp)) {
            $htmlString = '';
            foreach ($dom->childNodes as $cn) {
                $htmlString.= $dom->saveHtml($cn);
            }
        }*/ elseif ($dom->ownerDocument) {
            $htmlString = $dom->ownerDocument->saveHtml($dom);
        } else {
            $htmlString = $dom->saveHtml();
        }
        
        // make replaces
        $htmlString = html_entity_decode($htmlString);
        
        $htmlString = preg_replace('/<html>[\s\n\r]*<\/html>/', '', $htmlString);
        $htmlString = str_replace(array_keys($this->tobereplaced), array_values($this->tobereplaced), $htmlString);
        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);
        dom($htmlString, 'resulting', self::$depth+1);
        echo '</div>';
       
        if (self::$depth) {
            //$this->functions[$root->getName()] = $this->codebuffer->getTemplateFunction($root->getName(), $dom);
        } else {
            $tpl = '<?php use DomDocument\PhpTemplates\Component; ?>';
            foreach ($this->document->getFunctions() as $key => $fn) {
                //d('---', $fn);
                $tpl .= (PHP_EOL.$fn);
            }
            $tpl.= (PHP_EOL.$htmlString);
            $this->document->setContent($tpl);
        }
        //if (strpos($htmlString, 'label') !== false) dd($htmlString);
        self::$depth--;
        //d('---',$htmlString);
        return $htmlString;
    }
    
    private function parseNode($node, $asFunction = null)
    {
        $attrs = Helper::getClassifiedNodeAttributes($node);
        $this->codebuffer->nestedExpression($attrs['c_structs'], function() use ($node) {
            if ($node->nodeName === 'slot') {
                $slotName = $node->getAttribute('name');
                if (!$slotName) {
                    $slotName = 'default';
                }
                $this->insertSlot($node);
            } 
            elseif (Helper::isComponent($node)) {
                $this->insertComponent($node);
                return $node;
            }
            else {
                $this->parseSimpleNode($node);
            }
            
            foreach ($node->childNodes ?? [] as $_node) {//d($_node);
                $this->parseNode($_node);
            }
        });
        return $node;
    }
  
    private function insertSlot($node)
    {
        $cbf = new CodeBuffer;
        dom($node, 'insertSlot', self::$depth);
        $sname = $node->getAttribute('name');//dom($node);
        if (empty($sname)) {
            $sname = 'default';
        }
        $attrs = Helper::getClassifiedNodeAttributes($node);
        $cbf->if('!empty($slots["'.$sname.'"])', function() use ($sname, $attrs, $cbf) {
            $cbf->nestedExpression($attrs['c_structs'], function () use ($sname, $attrs, $cbf) {
                $cbf->foreach('$slots["'.$sname.'"] as $slot', function() use ($attrs, $cbf) {
                    $dataArrString = Helper::arrayToEval($attrs['attrs']);
                    $cbf->push('$slot->render(array_merge($data, '.$dataArrString.'));');
                });
            });
        });
        //$this->codebuffer->else('x', function() {});
//d(124, $this->codebuffer->getStream());
        if ($node->childNodes && $node->childNodes->length) {
            $cbf->else(null, function() use ($node, $cbf) {
                $cbf->push(' ?>');
                foreach ($node->childNodes as $cn) {//d($cn);
                    if (Helper::isEmptyNode($cn)) {
                        continue;
                    }
                    //dom($cn);
                    // verifica intai daca e comp
                    $cbf->push('
                    '.(new Parser($this->document, $cbf))->parse($cn));
                }
                $cbf->push('
                <?php ');
            });
            //dd(12, $this->codebuffer->getStream());
        }
        buf((object)['codebuffer'=>$cbf], 'init _slot_', self::$depth);
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($cbf->getStream(true)),
            $node
        );
        $this->toberemoved[] = $node;
    }
    
    private function insertComponent($node, $nestLvl = 0)// param2slotnodelist pentru recursivitate
    {
        dom($node, 'insertComponent', $nestLvl);
        $data = Helper::getClassifiedNodeAttributes($node);// si le si stergem
        $rfilepath = Helper::isComponent($node);
        if ($rfilepath) {
            $fnName = DomHolder::getTemplateName($rfilepath, $data['attrs']);
        } else {
            $fnName = 'slot_'.($data['slot'] ?? 'default').'_'.uniqid();
        }
        $dataArrString = Helper::arrayToEval($data['attrs']);
        if ($nestLvl) {
            $pos = $data['slot'] ?? 'default';
            $this->codebuffer->push('
            $comp'.($nestLvl).' = $comp'.($nestLvl-1)."->addSlot('$pos', new Component('$fnName', $dataArrString));");   
        } else {//d(124);
            $this->codebuffer->push('
            $comp'.$nestLvl." = new Component('$fnName', $dataArrString);");
        }
        if (!$this->document->hasFunction($fnName)) {
            $dom = $rfilepath ? DomHolder::get($rfilepath, $data['attrs']) : $node;
            $htmlString = (new Parser($this->document, new CodeBuffer))->parse($dom, $rfilepath == true);
            $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
            $this->document->registerFunction($fnName, $htmlString);//d('---', $htmlString);
        }
        buf($this, 'init component', self::$depth);
        foreach ($node->childNodes ?? [] as $slotNode) {//d('777');dom($slotNode);
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }
            dom($slotNode, ' slot node detected', $nestLvl);
            $this->insertComponent($slotNode, $nestLvl+1);
/*
            $attrs = Helper::getClassifiedNodeAttributes($slotNode);
            // recursive register if and for stmnts nested
            if ($rfilepath = Helper::isComponent($slotNode)) {
                $fnName = DomHolder::getTemplateName($rfilepath, Helper::getNodeAttributes($slotNode));
                if (!$this->document->hasFunction($fnName)) {
                    //$slotNode = DomHolder::get($rfilepath, $attrs['attrs']);
                    $htmlString = (new Parser($this->document, $buffer))->parse($slotNode, true);
                    $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                    $this->document->registerFunction($fnName, $htmlString);
                }
            } else {
                $htmlString = (new Parser($this->document, $this->codebuffer))->parse($slotNode);
                $fnName = 'slot_'.$attrs['slot'].'_'.uniqid();
                $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                $this->document->registerFunction($fnName, $htmlString);
            }
            // d($fnName);
            $this->codebuffer->nestedExpression($attrs['c_structs'], function() use ($fnName, $attrs) {//d(234, $fnName);
                $dataArrString = Helper::arrayToEval($attrs['attrs']);
                $this->codebuffer->push('
                $comp'.(self::$depth+1).' = $comp'.self::$depth."->addSlot('{$attrs['slot']}', new Component('$fnName', $dataArrString));");
                buf($this, 'init slot', self::$depth);
            });//d($this->codebuffer->getStream());
*/
            //d(333, $fnName);
            /*
            $attrs = Helper::getClassifiedNodeAttributes($slotNode, 2);
            // recursive register if and for stmnts nested
            if ($rfilepath = Helper::isComponent($slotNode)) {
                $fnName = DomHolder::getTemplateName($rfilepath, Helper::getNodeAttributes($slotNode));
                if (!$this->document->hasFunction($fnName)) {
                    $slotNode = DomHolder::get($rfilepath, $attrs['attrs']);
                    $htmlString = (new Parser($this->document, new CodeBuffer))->parse($slotNode, true);
                    $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                    $this->document->registerFunction($fnName, $htmlString);
                }
            } else {
                $htmlString = (new Parser($this->document, new CodeBuffer))->parse($slotNode);
                $fnName = 'slot_'.$attrs['slot'].'_'.uniqid();
                $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                $this->document->registerFunction($fnName, $htmlString);
            }//d(333, $fnName);
            $this->codebuffer->nestedExpression($attrs['c_structs'], function() use ($fnName, $attrs) {
                $dataArrString = Helper::arrayToEval($attrs['attrs']);
                $this->codebuffer->push('
                $comp'.(self::$depth+1).' = $comp'.self::$depth."->addSlot('{$attrs['slot']}', new Component('$fnName', $dataArrString));");
                // pentru fiecare child, facem parse, daca am avut comp
                if ($rfilepath) {
                    foreach ($slotNode->childNodes as $snode) {
                        if (Helper::isEmptyNode($slotNode)) {
                            continue;
                        }
                        // insert component
                        //$this->parseNode();
                    }
                }
            });*/
            //d($this->codebuffer->getStream());
        }
        if (!$nestLvl) {
            $this->codebuffer->push('
            $comp0->render($data);');//d(345,$this->codebuffer->getStream());
            buf($this, 'resulting ', self::$depth);
            $node->parentNode->insertBefore(
                $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
                $node
            );
        }
        $this->toberemoved[] = $node;
    }
    
    private function parseSimpleNode($node)
    {//dom($node,34);
        $toberemoved = [];
        $cstructs = [];
        $pf = Config::get('prefix');
        $bpf = ':';
        foreach ($node->attributes ?? [] as $attr) {//d($attr);
            $k = $attr->nodeName;// d($k);
            if (strpos($k, $pf) === 0) {//d($k, $pf);
                $expr = substr($k, strlen($pf));
                if ($expr === 'raw') {
                    $rid = '__r'.uniqid();
                    $this->tobereplaced[$rid] = "<?php echo ({$attr->nodeValue}); ?>";
                    $node->setAttribute($rid, '__empty__');
                    $toberemoved[] = $k;
                    continue;
                }
                elseif ($expr === 'bind') {
                    $rid = '__r'.uniqid();
                    $this->tobereplaced[$rid] = "<?php foreach({$attr->nodeValue} as ".'$k=>$v) echo "$k=\"$v\" "; ?>';
                    $node->setAttribute($rid, '__empty__');
                    $toberemoved[] = $k;
                    continue;
                }
                if (!in_array($expr, Config::allowedControlStructures)) {
                    continue;
                }
                if ($attr->nodeValue) {
                    $expr .= " ({$attr->nodeValue})";
                }//d($node->parentNode);
                $this->insertBefore(
                    $node->ownerDocument->createTextNode("<?php $expr { ?>"),
                    $node
                );
                $this->insertAfter(
                    $node->ownerDocument->createTextNode("<?php } ?>"),
                    $node
                );
                $toberemoved[] = $k;
            }
            elseif (strpos($k, ':') === 0) {
                $a = substr($k, 1);
                $rid = '__r'.uniqid();
                if ($nattr = $node->getAttribute($a)) {
                    $node->setAttribute($a, $nattr." $rid");
                } else {
                    $node->setAttribute($a, $rid);
                }
                $this->tobereplaced[$rid] = "<?php echo {$attr->nodeValue} ;?>";
                $toberemoved[] = $k;
            }
        }
        foreach ($toberemoved as $attr) {
            $node->removeAttribute($attr);
        }
        //if ($node->nodeName === 'option') dd(134);
          // foreach attrs as attr, 
            // conditionating
            // check for special attrs
            // make replacing system
    }
    
    public function insertBefore($newNode, $ref)
    {
        $ref->parentNode->insertBefore($newNode, $ref);
    }
    
    public function insertAfter($newNode, $ref)
    {
        if ($ref->nextSibling) {
            $ref->parentNode->insertBefore($newNode, $ref->nextSibling);
        } else {
            $ref->parentNode->appendChild($newNode);
        }
    }
    
    public function __get($prop)
    {
        return $this->$prop;
    }
}