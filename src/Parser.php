<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;
use DomDocument\PhpTemplates\Facades\DomHolder;
//use DomDocument\PhpTemplates\Template;
//use DomDocument\PhpTeplates\Parsable;

class Parser
{//slot in slot pune mereu default ca name de unde ia, see a.php
    private $document;
    private $codebuffer;
    private $name;
    
    private $tobereplaced = [
        '="__empty__"' => '',
    ];
    private $toberemoved = [];
    
    protected static $depth = -1;
//sloturile in insertcompslot se adauga cu data de la parent pe atribute, ceea ce nu e ok... trb sa se adauge cu data ce primeste prin attrs pe nod daca e comp
    public function __construct(Document $doc, string $name, CodeBuffer $cbf = null)
    {
        $this->name = $name;
        $this->document = $doc;
        $this->codebuffer = $cbf ?? new CodeBuffer;
    }

    /**
     * as root, comp, slot
     */
    public function parse($dom = null)
    {
        //d($this->name);
        self::$depth++;
        
        $trimHtml = false;
        if (!$dom || Helper::isComponent($dom)) {
            $requestName = preg_replace('(\.template|\.php)', '', $this->name);
            $f = Config::get('src_path');
            $srcFile = $f.$requestName.'.template.php';
            $dom = new HTML5DOMDocument;//d($this->srcFile);
            $dom->formatOutput = true;
            $html = file_get_contents($srcFile);
            $html = $this->removeHtmlComments($html);
            $trimHtml = strpos($html, '<body') === false; // trim doar daca nu exista html definit de user
            $dom->loadHtml($html);//d($srcFile, $html,  $dom->saveHtml());
            if ($extends = $dom->querySelector('extends')) {
                $this->extends($extends);
            }
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
        //dom($dom, 'parsing on depth '.self::$depth, self::$depth);
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
        //dom($htmlString, 'resulting', self::$depth+1);
        if (!empty($_GET['debug'])) {
            echo '</div>';
        }
       
        // obtine fn name here, poate fi isComponent, poate fi is Slot, poate fi isSlot ca si component
        // daca is component, vine direct nodul si ii am numele
        //if (strpos($htmlString, 'label') !== false) dd($htmlString);
        self::$depth--;

        // default register aici
        $htmlString = CodeBuffer::getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }
    
    private function parseNode($node, $asFunction = null)
    {
        //$data = Helper::nodeStdClass($node);
        //$this->codebuffer->nestedExpression($data->statements, function() use ($node, $data) {
            if ($node->nodeName === 'slot') {
                $this->insertSlot($node);
            } 
            elseif ($node->nodeName === 'block') {
                $this->insertBlock($node);
            } 
            elseif (Helper::isComponent($node)) {
                $this->insertComponent($node);// d('---comp');
                // to prevent removing body
                return $node;
            }
            else {
                try {
                //d($node->getAttribute('p-for'));
                } catch(Exception $e) {} 
                $this->parseSimpleNode($node);
            }
            
            foreach ($node->childNodes ?? [] as $_node) {//d($_node);
                $this->parseNode($_node);
            }
        //});
        return $node;
    }
  
    private function insertSlot($node, $i = 0, $deep = false)
    {
        $cbf = new CodeBuffer;
        //dom($node, 'insertSlot', self::$depth);
        $data = Helper::nodeStdClass($node);
        $cbf->nestedExpression($data->statements, function() use ($data, $cbf, $node, $i, $deep) {
        $slotName = $data->name;
        $cbf->if('!empty($slots["'.$slotName.'"])', function() use ($data, $cbf, $i, $slotName, $deep) {
            //$cbf->nestedExpression($attrs['c_structs'], function () use ($sname, $attrs, $cbf) {
                $cbf->foreach("\$slots['$slotName'] as \$slot", function() use ($data, $cbf, $i, $slotName, $deep) {
                    $dataString = Helper::arrayToEval($data->attributes);
                    if ($deep) {
                        //$this->codebuffer->if('$comp'.$nestLvl.'->parent', function() use ($data, $nestLvl, $slotName) {
                        $this->codebuffer->foreach('$this->slots["'.$data->name.'"] ?? [] as $slot', function() use ($data, $i, $slotName) {
                            $this->codebuffer->raw("\$comp{$i}->addSlot('{$data->slot}', \$slot);");
                        });
                        //slot trecut aici
                        ///});
                    } else {
                        //si aici
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
                foreach ($slotDefault as $sd) {
                    if ($sd->nodeName === 'slot') {
                        continue;
                    }
                    //iar ii bagam sloturile si la asta,ca sa fie ok
                    $rfilepath = Helper::isComponent($sd);
                    $fnName = $rfilepath ?? 'slot_def_'.uniqid();
                    if ($rfilepath) {
                        // toggle buffers
                        $tmp = $this->codebuffer;
                        $this->codebuffer = $cbf;
                        $this->insertComponent($sd, true);//cbf....
                        $this->codebuffer = $tmp;
                        //d($this->codebuffer->getStream()); // e resetat...
                    } else {
                        (new Parser($this->document, $fnName))->parse($rfilepath ? null : $sd);
                        $cbf->raw("\$comp = Parsed::template('$fnName', \$data);");
                        $cbf->raw('$comp->setSlots($slots);');
                        $cbf->raw('$comp->render($data);');
                    }
                }
                //$cbf->raw($cbfDefault->getStream());
            });
            //dd(12, $this->codebuffer->getStream());
        }
        });
        buf((object)['codebuffer'=>$cbf], 'init _slot_', self::$depth);
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($cbf->getStream(true)),
            $node
        );
        $this->toberemoved[] = $node;
    }

    private function insertBlock($node)
    {
        $data = Helper::nodeStdClass($node);
        $cbf = new CodeBuffer;
        $cbf->raw('$blocks = [];echo $_name;');
        foreach ($node->childNodes as $childNode) {
            $rfilepath = Helper::isComponent($childNode);
            $fnName = $rfilepath ? $rfilepath : 'block_'.$data->name.'_slot_'.uniqid();
            $_data = Helper::nodeStdClass($childNode);
            $dataString = Helper::arrayToEval($_data->attributes);
            if (!isset($this->document->templates[$fnName])) {
                (new Parser($this->document, $fnName))->parse($rfilepath ? null : $childNode);
            }
            $cbf->raw("\$blocks[] = Parsed::template('$fnName', $dataString);");
        }
        $cbf->if("isset(\$slots['{$data->name}'])", function() use ($data, $cbf) {
            //push slots
            $cbf->foreach("\$slots['{$data->name}'] as \$slot", function() use ($cbf) {
                $cbf->raw("\$blocks[] = \$slot;");
            });
        });
        //$cbf->raw('sort $blocks');
        $cbf->foreach('$blocks as $block', function() use ($cbf) {
            $cbf->raw('$block->render($data);');
        });
        
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($cbf->getStream(true)),
            $node
        );
        $this->toberemoved[] = $node;
    }
    
    private function insertComponent($node, $nestLvl = 0)// param2slotnodelist pentru recursivitate
    {
        $data = Helper::nodeStdClass($node);// si le si stergem
        $this->codebuffer->nestedExpression($data->statements, function() use ($node, $data, $nestLvl) {
            $i = 0; // self::$depth;
            //dom($node, 'insertComponent', $nestLvl);
            $fnName = Helper::isComponent($node);
    
            //$dataString = Helper::arrayToEval($data->attributes);
            $last = $i-1;
        //if (!$i) {
            $this->codebuffer->component($fnName, $data->attributes);
            //->raw("\$comp{$i} = Parsed::template('$fnName', $dataString);");
            
            //} else {
            //$this->codebuffer->raw("\$comp{$i} = \$comp{$last}->addSlot('$data->slot', Parsed::template('$fnName', $dataString));");
            //}
            if (!isset($this->document->templates[$fnName])) {
                (new Parser($this->document, $fnName))->parse();
            }
    
            buf($this, 'init component', self::$depth);
        
            $slots = $this->getNodeSlots($node);
          
            $slotOf = $fnName;
            foreach ($slots as $slotPosition => $slotNodes) {
            foreach ($slotNodes as $slotNode) {
                if ($slotNode->nodeName === 'slot') {
                    $this->insertSlot($slotNode, 0, true);// va disparea de aivi
                    ///is slotnode, comp addslot if exist din slots.position
                    /*
                    $bound = $slotNode->getAttribute('name');
                    $this->codebuffer->if("isset(\$slots['$bound'])", function() use ($bound, $slotPosition) {
                        $this->codebuffer->foreach("\$slots['$bound'] as \$bound", function() use ($slotPosition) {
                            $this->codebuffer->raw("\$comp->addSlot('$slotPosition', \$bound");
                        });
                    });*/
                }
                elseif ($slotNode->nodeName === 'block') {
                    $this->insertBlock($slotNode);
                }
            else {
                $this->insertComponentSlot($slotPosition, $slotNode);
                }
                }
            }
            $this->codebuffer->raw('$comp0->render($data);');//d(345,$this->codebuffer->getStream());
        });
        //dd($this->codebuffer->getStream());
        //if (!$i) {
        buf($this, 'resulting ', self::$depth);
        if ($nestLvl) {
            return;
        }
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );
        //}

        $this->toberemoved[] = $node;
    }
    
    protected function insertComponentSlot($slotPosition, $slotNode, $i = 0)
    {
       // check aici dupa slot in slot
       if ($slotNode->nodeName === 'slot') {
            $this->insertSlot($slotNode, $i, true);
            return;
       }
       
        $n = Helper::nodeStdClass($slotNode);
        $this->codebuffer->nestedExpression($n->statements, function() use ($n, $slotNode, $slotPosition, $i) {
        //if ($slotNode->nodeName === '#text') d($slotNode->nodeValue, $i);
        $slotOf = 'slotOf';
        $rfilepath = Helper::isComponent($slotNode);
        $fnName = $rfilepath ?? $slotOf.'_'.uniqid().'_slot_'.$slotPosition;
        //$i = self::$depth + 1; //anticipat
        $next = $i+1;
        $this->codebuffer->slot($i, $slotPosition, $fnName, $n->attributes);//("\$comp{$next} = \$comp{$i}->addSlot('$slotPosition', Parsed::template('$fnName', \$data));");
        //d(123, $fnName);
        if (!isset($this->document->templates[$fnName])) {
        (new Parser($this->document, $fnName))->parse($rfilepath ? null : $slotNode);// aici se rupe
        // data here
        }
        if ($slotNode->nodeName !== '#text')$slotNode->removeAttribute('slot');
        
        if ($rfilepath) {

        $slots = $this->getNodeSlots($slotNode);
      
        //$slotOf = $fnName;
        foreach ($slots as $slotPosition => $slotNodes) {
            foreach ($slotNodes as $slotNode) {//d($i+1);
                $this->insertComponentSlot($slotPosition, $slotNode, $i+1);
            }
        }
        } else {
            $this->codebuffer->raw("\$comp{$next}->setSlots(\$slots);");
        }
        });
        /*
        un depth local ++
        if node is component
          daca nu e comp inreg, new parsee cu component source
          foreach cn, insertComponentSlot
        if node is normal, unique parse pentru inreg
        
        this cbf addslot
        depth local--*/
    }
    
    private function parseSimpleNode($node)
    {//dom($node,34);
        // 
        
        //if ($node->nodeName !== '#text')@$node->removeAttribute('slot');
        $toberemoved = ['slot'];
        $cstructs = [];
        $pf = Config::get('prefix');
        $bpf = ':';
        foreach ($node->attributes ?? [] as $attr) {//dom($node);die();
        //dd($node, $node->getAttribute('p-for'));
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
        if (method_exists($node, 'removeAttribute')) {
        foreach ($toberemoved as $attr) {
            $node->removeAttribute($attr);
        }
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
/*
            if (!isset($slots[$slotPosition])) {
                $slots[$slotPosition] = new HTML5DOMDocument;
            }
            $slots[$slotPosition]->appendChild($slots[$slotPosition]->importNode($slotNode, true));
*/
            $slots[$slotPosition][] = $slotNode;
        }
        
        return $slots;
    }
    
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
    
    protected function extends($extends)
    {
        //$extendedLayout = $extends->getAttribute('layout');
        $extendedTemplate = $extends->getAttribute('template');
        //$extendMethod = $extendedLayout ? 'getLayout' : 'getTemplate';
        //$extended = $extendedLayout ? $extendedLayout : $extendedTemplate;
        // document registerEvent( cu urmatorul format)
            // template va asimila Component si are un event pe new care se asigura ca parseaza ce primeste, in cazul in care nu exista inregistrat (sloturile fac register mai inainte)
        // actualul component
        (new Parser($this->document, $extendedTemplate))->parse();
        
        $this->document->addEventListener('rendering', $this->name, "function(\$template, \$data) {
            \$comp = Parsed::template('$extendedTemplate');
            \$comp->addSlot('default', \$template);
            \$comp->render(\$data);
            return false;
        }");
    }
    
    protected function getTemplate($rfilepath)
    {
        // fac parse folosind acelasi document si automat ca va face register componentei
        if (!isset($this->document->templates[$rfilepath])) {
            (new Parser($this->document, $rfilepath))->parse();
        }
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}