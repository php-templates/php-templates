<?php

namespace DomDocument\PhpTemplates\Entities;

use DomDocument\PhpTemplates\CodeBuffer;
use DomDocument\PhpTemplates\Document;
use DomDocument\PhpTemplates\Helper;
use DomDocument\PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class Slot extends Parser implements Mountable
{
    protected $document;
    protected $name;
    protected $i;
    protected $nest;
    protected $codebuffer;
    
    public function __construct(Document $doc, $i = 0, $nest = false)
    {
        $this->document = $doc;
        $this->i = $i;
        $this->nest = $nest;
        $this->codebuffer = new CodeBuffer;
    }

    public function mount(HTML5DOMElement $node): void
    {
        $this->insertSlot($node);

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );
        $this->document->toberemoved[] = $node;
    }

    public function _mount(HTML5DOMElement $node, CodeBuffer $cbf)
    {
        $this->codebuffer = $cbf;

        $this->insertSlot($node);
    }

    public function insertSlot($node)
    {
        $nodeData = Helper::nodeStdClass($node);
        $this->name = $nodeData->name;

        $this->codebuffer->nestedExpression($nodeData->statements, function() use ($nodeData, $node) {
            if (!$this->nest) {
                //$this->codebuffer->raw("DomEvent::event('renderingSlots', '$this->name', \$slots['$this->name'] ?? [], []);");
            }
            $this->codebuffer->if('!empty($slots["'.$this->name.'"])', function() use ($nodeData) {
                $this->codebuffer->foreach("\$slots['$this->name'] as \$slot", function() use ($nodeData) {
                    $dataString = Helper::arrayToEval($nodeData->attributes);
                    if ($this->nest) {
                        $this->codebuffer->raw("\$comp{$this->i}->addSlot('{$nodeData->slot}', \$slot);");
                    } else {
                        $this->codebuffer->raw('$slot->render(array_merge($data, '.$dataString.'));');
                    }
                });
            }); 
            if ($slotDefault = $this->getNodeSlots($node, true)) {
                $slotDefault = $slotDefault['default'];
                // check for empty cn first
                $this->codebuffer->else(null, function() use ($slotDefault) {
                    foreach ($slotDefault as $_node) {
                        // skip empty nodes
                        if ($_node->nodeName === 'slot') {
                            continue;
                        }
                        
                        $_name = $isComponent = Helper::isComponent($_node);
                        $_name = $_name ? $_name : 'slot_default?id='.uniqid();
                        if ($isComponent) {
                            (new Component($this->document, $_name))->_mount($_node, $this->codebuffer);
                        } else {
                            $_nodeData = Helper::nodeStdClass($_node);
                            (new Parser($this->document, $_name))->parse($_node);
                            $this->codebuffer->nestedExpression($_nodeData->statements, function() use ($_name, $_nodeData) {
                                $this->codebuffer->component($_name, $_nodeData->attributes);
                                $this->codebuffer->raw('$comp0->setSlots($slots);');
                                $this->codebuffer->raw('$comp0->render($data);');
                            });
                        }
                    }
                });
            }
        });
    }
}