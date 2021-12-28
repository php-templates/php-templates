<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;
use DomDocument\PhpTemplates\Facades\DomHolder;

class Parser
{
    private $document;
    private $codebuffer;
    private $name;
    
    private $tobereplaced = [
        '="__empty__"' => '',
    ];
    private $toberemoved = [];
    
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

        $this->parseNode($dom);

        while ($this->toberemoved) {
            $node = array_pop($this->toberemoved);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }
        
        if ($trimHtml) {
            $htmlString = DomHolder::trimHtml($dom);
        }
        elseif ($dom->ownerDocument) {
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

        // default register aici
        $htmlString = CodeBuffer::getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }
    
    private function parseNode($node, $asFunction = null)
    {
        $nodeData = Helper::nodeStdClass($node);
        //$this->codebuffer->nestedExpression($data->statements, function() use ($node, $data) {
            if ($node->nodeName === 'slot') {
                $this->insertSlot($node);
            } 
            elseif ($node->nodeName === 'block') {
                $name = "block_$nodeData->name".'_'.uniqid();
                $this->insertBlock($node, $name);
                return;
            } 
            elseif (Helper::isComponent($node)) {
                $this->insertComponent($node);// d('---comp');
                // to prevent removing body
                return $node;
            }
            else {
                try {
                //d($node->getAttribute('p-for'));
                } catch(\Exception $e) {} 
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
        $data = Helper::nodeStdClass($node);
        $cbf->nestedExpression($data->statements, function() use ($data, $cbf, $node, $i, $deep) {
        $slotName = $data->name;
        $cbf->if('!empty($slots["'.$slotName.'"])', function() use ($data, $cbf, $i, $slotName, $deep) {
            $cbf->foreach("\$slots['$slotName'] as \$slot", function() use ($data, $cbf, $i, $slotName, $deep) {
                $dataString = Helper::arrayToEval($data->attributes);
                if ($deep) { 
                    $this->codebuffer->foreach('$this->slots["'.$data->name.'"] ?? [] as $slot', function() use ($data, $i, $slotName) {
                        $this->codebuffer->raw("\$comp{$i}->addSlot('{$data->slot}', \$slot);");
                    });
                } else {
                    //si aici
                    $cbf->raw('$slot->render(array_merge($data, '.$dataString.'));');
                }
            });
        }); 
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
                        $this->insertComponent($sd, true);
                        $this->codebuffer = $tmp;
                    } else {
                        (new Parser($this->document, $fnName))->parse($rfilepath ? null : $sd);
                        $cbf->raw("\$comp = Parsed::template('$fnName', \$data);");
                        $cbf->raw('$comp->setSlots($slots);');
                        $cbf->raw('$comp->render($data);');
                    }
                }
            });
        }
        });

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($cbf->getStream(true)),
            $node
        );
        $this->toberemoved[] = $node;
    }

    private function insertBlock($node, $blockName)
    {
        $nest = !empty($cbf);
        $data = Helper::nodeStdClass($node);
        $cbf = new CodeBuffer;
        $cbf->raw('$blocks = [];');
        foreach ($node->childNodes as $childNode) {
            if (Helper::isEmptyNode($childNode)) {
                continue;
            }
            //if e block, insertblock cu nestlvl, ia
            if ($childNode->nodeName === 'block') {
                $b = Helper::nodeStdClass($childNode);
                $bname = "block_$b->name".'_'.uniqid();
                $this->insertBlock($childNode, $bname);
                $cbf->raw("\$blocks[] = Parsed::template('$bname', []);");
                continue;
            }
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
        $cbf->foreach('$blocks as $block', function() use ($cbf) {
            $cbf->raw('$block->render($data);');
        });
        
        $htmlString = CodeBuffer::getTemplateFunction($cbf->getStream(true));
        $this->document->templates[$blockName] = $htmlString;
        
        if ($nest) {
            return;
        }
        
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode("<?php Parsed::template('$blockName', [])->setSlots(\$slots)->render(\$data); ?>"),
            $node
        );
        $this->toberemoved[] = $node;
    }
    
    private function insertComponent($node, $nestLvl = 0)
    {
        $data = Helper::nodeStdClass($node);// si le si stergem
        $this->codebuffer->nestedExpression($data->statements, function() use ($node, $data, $nestLvl) {
            $fnName = Helper::isComponent($node);
    
            $this->codebuffer->component($fnName, $data->attributes);
            if (!isset($this->document->templates[$fnName])) {
                (new Parser($this->document, $fnName))->parse();
            }
 
            $slots = $this->getNodeSlots($node);
          
            $slotOf = $fnName;
            foreach ($slots as $slotPosition => $slotNodes) {
                foreach ($slotNodes as $slotNode) {
                    if ($slotNode->nodeName === 'slot') {
                        $this->insertSlot($slotNode, 0, true);// va disparea de aivi
                        ///is slotnode, comp addslot if exist din slots.position
                    }
                    elseif ($slotNode->nodeName === 'block') {
                        $this->insertBlock($slotNode);
                    }
                    else {
                        $this->insertComponentSlot($slotPosition, $slotNode);
                    }
                }
            }
            $this->codebuffer->raw('$comp0->render($data);');
        });

        if ($nestLvl) {
            return;
        }
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );

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
            $slotOf = 'slotOf';
            $rfilepath = Helper::isComponent($slotNode);
            $fnName = $rfilepath ?? $slotOf.'_'.uniqid().'_slot_'.$slotPosition;
            $next = $i+1;
            $this->codebuffer->slot($i, $slotPosition, $fnName, $n->attributes);
            if (!isset($this->document->templates[$fnName])) {
                (new Parser($this->document, $fnName))->parse($rfilepath ? null : $slotNode);// aici se rupe
            // data here
            }
            if ($slotNode->nodeName !== '#text')$slotNode->removeAttribute('slot');
            
            if ($rfilepath) {
                $slots = $this->getNodeSlots($slotNode);
                foreach ($slots as $slotPosition => $slotNodes) {
                    foreach ($slotNodes as $slotNode) {
                        $this->insertComponentSlot($slotPosition, $slotNode, $i+1);
                    }
                }
            } else {
                $this->codebuffer->raw("\$comp{$next}->setSlots(\$slots);");
            }
        });
    }
    
    private function parseSimpleNode($node)
    {
        $toberemoved = ['slot'];
        $cstructs = [];
        $pf = Config::get('prefix');
        $bpf = ':';
        foreach ($node->attributes ?? [] as $attr) {
            $k = $attr->nodeName;
            if (strpos($k, $pf) === 0) {
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
                }
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
        
        foreach ($node->childNodes as $slotNode) {
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }
            
           $slotPosition = $slotNode->nodeName !== '#text' ? $slotNode->getAttribute('slot') : 'default';
            if ($forceDefault || !$slotPosition) {
                $slotPosition = 'default';
            }

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

    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);

        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node);
        }
        return $content;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}