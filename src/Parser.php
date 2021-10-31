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
    
    private $tobereplaced = [];
    private $toberemoved = [];
    
    protected static $depth = -1;

    public function __construct(Document $doc, CodeBuffer $buffer)
    {
        $this->document = $doc;
        $this->codebuffer = $buffer;
    }

    public function parse($dom, $trimHtml = false)
    {
        self::$depth++;
//d('parsing');dom($dom);
        $this->parseNode($dom);

        while ($this->toberemoved) {
            $node = array_pop($this->toberemoved);
                //echo 'removing'; dom($node);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }
        
        if ($trimHtml) {
            $htmlString = DomHolder::trimHtml($dom);
        } elseif ($dom->ownerDocument) {
            $htmlString = $dom->ownerDocument->saveHtml($dom);
        } else {
            $htmlString = $dom->saveHtml();
        }
        
        // make replaces
        $htmlString = html_entity_decode($htmlString);
        if (self::$depth) {
            //$this->functions[$root->getName()] = $this->codebuffer->getTemplateFunction($root->getName(), $dom);
        } else {
            $tpl = '<?php use DomDocument\PhpTemplates\Component; ?>';
            foreach ($this->document->getFunctions() as $key => $fn) {
                d('---', $fn);
                $tpl .= $fn;
            }
            $tpl.= $htmlString;
            $this->document->setContent($tpl);
        }
        
        $htmlString = str_replace(array_keys($this->tobereplaced), array_values($this->tobereplaced), $htmlString);
        
        self::$depth--;
        
        return $htmlString;
    }
    
    private function parseNode($node)
    {
        if ($node->nodeName === 'slot') {
            $slotName = $node->getAttribute('name');
            if (!$slotName) {
                $slotName = 'default';
            }
            
            $this->insertSlot($node);
        } 
        elseif (Helper::isComponent($node)) {
            $this->insertComponent($node);
        }
        else {
            $this->parseSimpleNode($node);
        }
        
        foreach ($node->childNodes ?? [] as $_node) {//d($_node);
            $this->parseNode($_node);
        }
        return $node;
    }
  
    private function insertSlot($node)
    {
        $sname = $node->getAttribute('name');//dom($node);
        if (empty($sname)) {
            $sname = 'default';
        }
        $attrs = Helper::getClassifiedNodeAttributes($node);
        $this->codebuffer->if('!empty($slots["'.$sname.'"])', function() use ($sname, $attrs) {
            $this->codebuffer->nestedExpression($attrs['c_structs'], function () use ($sname, $attrs) {
                $this->codebuffer->foreach('$slots["'.$sname.'"] as $slot', function() use ($attrs) {
                    $dataArrString = Helper::arrayToEval($attrs['attrs']);
                    $this->codebuffer->push('$slot->render('.$dataArrString.');');
                });
            });
        });

        if ($node->childNodes && $node->childNodes->length) {
            $this->codebuffer->else(null, function() use ($node) {
                $this->codebuffer->push(' ?>');
                foreach ($node->childNodes as $cn) {//d($cn);
                    if (Helper::isEmptyNode($cn)) {
                        continue;
                    }
                    
                    $this->codebuffer->push('
                    '.(new Parser($this->document, new CodeBuffer))->parse($cn));
                }
                $this->codebuffer->push('
                <?php ');
            });
        }
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );
        $this->toberemoved[] = $node;
    }
    
    private function insertComponent($node)
    {
        $data = Helper::getClassifiedNodeAttributes($node);// si le si stergem
        $rfilepath = Helper::isComponent($node);
        $fnName = DomHolder::getTemplateName($rfilepath, $data['attrs']);
        if (!$this->document->hasFunction($fnName)) {
            $dom = DomHolder::get($rfilepath, $data['attrs']);
            $htmlString = (new Parser($this->document, new CodeBuffer))->parse($dom, true);
            $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
            $this->document->registerFunction($fnName, $htmlString);
        }
        $dataArrString = Helper::arrayToEval($data['attrs']);
        $this->codebuffer->push('
        $comp'.self::$depth." = new Component('$fnName', $dataArrString);");
        
        foreach ($node->childNodes as $slotNode) {
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }
            $attrs = Helper::getClassifiedNodeAttributes($slotNode);
            // recursive register if and for stmnts nested
            if ($rfilepath = Helper::isComponent($slotNode)) {
                $fnName = DomHolder::getTemplateName($rfilepath, Helper::getNodeAttributes($slotNode));
                if (!$this->document->hasFunction($fnName)) {
                    // unpack
                    $htmlString = (new Parser($this->document, $this->codebuffer))->parse($slotNode);
                    $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                    $this->document->registerFunction($fnName, $htmlString);
                }
            } else {
                $htmlString = (new Parser($this->document, $this->codebuffer))->parse($slotNode);
                $fnName = 'slot_'.$attrs['slot'].'_'.uniqid();
                $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                $this->document->registerFunction($fnName, $htmlString);
            }
            $this->codebuffer->nestedExpression($attrs['c_structs'], function() use ($fnName, $attrs) {
                $dataArrString = Helper::arrayToEval($attrs['attrs']);
                $this->codebuffer->push('
                $comp'.(self::$depth+1).' = $comp'.self::$depth."->addSlot('{$attrs['slot']}', new Component('$fnName', $dataArrString));");
            });
        }
        $this->codebuffer->push('
        $comp0->render();');
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );
        
        $this->toberemoved[] = $node;
    }
    
    private function parseSimpleNode($node)
    {
        $cstructs = [];
        $pf = Config::get('prefix');
        $bpf = ':';
        foreach ($node->attributes ?? [] as $attr) {//d($attr);
            $k = $attr->nodeName;
            if (strpos($k, $pf) === 0) {
                $expr = substr($k, strlen($pf));
                //d(112, $expr);
                if (!in_array($expr, Config::allowedControlStructures)) {
                    continue;
                }
                if ($attr->nodeValue) {
                    $expr .= " ({$attr->nodeValue})";
                }
                $this->insertBefore(
                    $node->ownerDocument->createTextNode("<?php $expr { ?>"),
                    $node
                );
                $this->insertAfter(
                    $node->ownerDocument->createTextNode("<?php } ?>"),
                    $node
                );
                $node->removeAttribute($k);
            }
            elseif (strpos($k, ':') === 0) {
                $a = substr($k, 1);
                $rid = '__r'.uniqid();
                if ($nattr = $node->getAttribute($a)) {
                    $node->setAttribute($a, $nattr." $rid");
                } else {
                    $node->addAttribute($a, $rid);
                }
                $this->tobereplaced[$rid] = "<?php echo {$attr->nodeValue} ;?>";
                $node->removeAttribute($k);
            }
        }
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