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
    private $name;
    
    private $tobereplaced = [
        '="__empty__"' => '',
    ];
    private $toberemoved = [];
    
    protected static $depth = -1;

    public function __construct(Document $doc, string $name)
    {
        $this->name = $name;
        $this->document = $doc;
        $this->codebuffer = new CodeBuffer;
    }

    /**
     * as root, comp, slot
     */
    public function parse($dom = null)
    {
        $trimHtml = false;
        if (!$dom) {
            $requestName = preg_replace('(\.template|\.php)', '', $this->name);
            $f = Config::get('src_path');
            $srcFile = $f.$requestName.'.template.php';
            $dom = new HTML5DOMDocument;//d($this->srcFile);
            $dom->formatOutput = true;
            $html = file_get_contents($srcFile);
            $html = $this->removeHtmlComments($html);
            $trimHtml = strpos($html, '<body') === false; // trim doar daca nu exista html definit de user
            $dom->loadHtml($html);//d($srcFile, $html,  $dom->saveHtml());
            $dom = DomHolder::get($this->name);
        }
        // cbf e baza avum
        // doar if daca e as slot, bfr primit e initiat deja, si aici, mai jos, declar html parsat ca fn si push i
        // will accept only one root
        // anything that is not DOMDocument will be scoped to avoid insertbefore.after situations reference confusion
        /* will be moved 
        if ($dom->nodeName !== '#document' && $dom->nodeName !== '#text') {
            $temp = new HTML5DOMDocument;
            //$body = $temp->createnode('body');
            //$temp->childNodes->item(0)->appendChild();
            //$temp->removeChild($temp->childNodes->item(0));
            $dom = $temp->importNode($dom, true);
            $temp->appendChild($dom);//dom($temp, 33);die();
            $dom = $temp;
        }
        */
        //dom($dom);
//d('parsing');dom($dom);
        // self::$depth++;
        if (!empty($_GET['debug'])) {
            echo str_pad('', self::$depth+1, 'I').'<div style="border:1px solid gray;margin-left:'.(self::$depth*30).'px">';
        }
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
        
        if ($trimHtml) {
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
        $htmlString = preg_replace('/\?>[ \n\r]*<\?php/', '', $htmlString);
        $htmlString = str_replace(array_keys($this->tobereplaced), array_values($this->tobereplaced), $htmlString);
        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);
        dom($htmlString, 'resulting', self::$depth+1);
        if (!empty($_GET['debug'])) {
            echo '</div>';
        }
       
        // obtine fn name here, poate fi isComponent, poate fi is Slot, poate fi isSlot ca si component
        // daca is component, vine direct nodul si ii am numele
        //if (strpos($htmlString, 'label') !== false) dd($htmlString);
        self::$depth--;

        // default register aici
        $htmlString = $this->codebuffer->getTemplateFunction($this->name, $htmlString);
        $this->document->registerFunction($this->name, $htmlString);
    }
    
    private function parseNode($node, $asFunction = null)
    {
        
        $data = Helper::nodeStdClass($node);
        $this->codebuffer->nestedExpression($data->statements, function() use ($node, $data) {
            if ($node->nodeName === 'slot') {
                $this->insertSlot($node);
            } 
            elseif (Helper::isComponent($node)) {
                $this->insertComponent($node);
                // to prevent removing body
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
  
    private function insertSlot($node, $nestLvl = 0)
    {
        $cbf = new CodeBuffer;
        dom($node, 'insertSlot', self::$depth);
        $data = Helper::nodeStdClass($node);
        $slotName = $nestLvl ? $data->bind : $data->name;
        $cbf->if('!empty($slots["'.$slotName.'"])', function() use ($data, $cbf, $nestLvl, $slotName) {
            //$cbf->nestedExpression($attrs['c_structs'], function () use ($sname, $attrs, $cbf) {
                $cbf->foreach("\$slots['$slotName'] as \$slot", function() use ($data, $cbf, $nestLvl, $slotName) {
                    $dataString = Helper::arrayToEval($data->attributes);
                    if ($nestLvl) {
                        $this->codebuffer->foreach("\$slots['$slotName'] as \$slot", function() use ($data, $nestLvl, $slotName) {
                            $i = $nestLvl -1;
                            $this->codebuffer->raw("\$comp{$i}->addSlot('{$data->slot}', \$slot);");
                        });
                    } else {
                        $cbf->raw('$slot->render(array_merge($data, '.$dataString.'));');
                    }
                });
            //});
        });
        //$this->codebuffer->else('x', function() {});
        //d(124, $this->codebuffer->getStream());   
        if ($slotDefault = $this->getNodeSlots($node, true)) {
            $slotDefault = $slotDefault['default'];
            // check for empty cn first
            $cbf->else(null, function() use ($slotDefault, $cbf) {
                $fnName = 'slot_def_'.uniqid();
                $htmlString = (new Parser($this->document, $fnName))->parse($slotDefault);
                $htmlString = $this->codebuffer->getTemplateFunction($fnName, $htmlString);
                $this->document->registerFunction($fnName, $htmlString);
                $cbf->raw("\$comp = new Component('$fnName', \$data);");
                $cbf->raw('$comp->render($data);');
                //$cbf->raw($cbfDefault->getStream());
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
        $data = Helper::nodeStdClass($node);// si le si stergem
        $fnName = Helper::isComponent($node);

        $dataString = Helper::arrayToEval($data->attributes);
        $this->codebuffer->raw("\$comp = new Component('$fnName', $dataString);");

        if (!$this->document->hasFunction($fnName)) {
            (new Parser($this->document, $fnName))->parse();
        }

        buf($this, 'init component', self::$depth);
    
        $slots = $this->getNodeSlots($node);
      
        $slotOf = $fnName;
        foreach ($slots as $slotPosition => $slotNode) {
            $fnName = $slotOf.'_'.uniqid().'_slot_'.$slotPosition;
            (new Parser($this->document, $fnName))->parse($slotNode);
            $this->codebuffer->raw("\$comp->addSlot('$slotPosition', new Component('$fnName', \$data));");
        }
        $this->codebuffer->raw('$comp->render($data);');//d(345,$this->codebuffer->getStream());
        buf($this, 'resulting ', self::$depth);
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );

        $this->toberemoved[] = $node;
    }
    
    private function parseSimpleNode($node)
    {//dom($node,34);
        // 
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
    
    protected function getNodeSlots($node, $forceDefault = false): array
    {
        $slots = [];
        if (!$node->childNodes) {
            return $slots;
        }
        
        foreach ($node->childNodes as $slotNode) {//d('777');dom($slotNode);
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }
            
           $slotPosition = $slotNode->nodeName !== '#text' ? $slotNode->getAttribute('slot') : 'default';
            if ($forceDefault || !$slotPosition) {
                $slotPosition = 'default';
            }

            if (!isset($slots[$slotPosition])) {
                $slots[$slotPosition] = new HTML5DOMDocument;
            }
            $slots[$slotPosition]->appendChild($slots[$slotPosition]->importNode($slotNode, true));
        }
        
        return $slots;
    }
    
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}