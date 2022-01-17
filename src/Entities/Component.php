<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class Component extends Parser implements Mountable
{
    protected $document;
    protected $name;
    protected $codebuffer;
    
    public function __construct(Document $doc, string $name)
    {
        $this->document = $doc;
        $this->name = $name;
        $this->codebuffer = new CodeBuffer;
    }

    public function mount(HTML5DOMElement $node): void
    {
        $this->insertComponent($node);

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );

        $this->document->toberemoved[] = $node;
    }

    public function _mount(HTML5DOMElement $node, CodeBuffer $cbf)
    {
        // capture all buffer input to outside buffer
        $this->codebuffer = $cbf;
        $this->insertComponent($node);
    }

    protected function insertComponent($node)
    {
        $nodeData = Helper::nodeStdClass($node);
        $this->codebuffer->nestedExpression($nodeData->statements, function() use ($node, $nodeData) {
            $this->codebuffer->component($this->name, $nodeData->attributes);
            // parse component dispatched, only if not already parsed
            if (!isset($this->document->templates[$this->name])) {
                (new Parser($this->document, $this->name))->parse();
            }

            $slots = $this->getNodeSlots($node);
            foreach ($slots as $slotPosition => $slotNodes) {
                foreach ($slotNodes as $slotNode) {
                    if ($slotNode->nodeName === 'slot') {
                        // slot in slot
                        (new Slot($this->document, 0, true))->_mount($slotNode, $this->codebuffer);
                    }
                    // case anonymous component
                    elseif ($slotNode->nodeName === 'template' && !$slotNode->getAttribute('is')) {
                        (new AnonymousComponent($this->document))->_mount($slotNode, $this->codebuffer);
                    }
                    elseif ($slotNode->nodeName === 'block') {
                        (new Block($this->document))->_mount($slotNode, $this->codebuffer);
                    }
                    else {
                        $this->insertComponentSlot($slotPosition, $slotNode);
                    }
                }
            }
            $this->codebuffer->raw('$this->comp[0]->render($this->data);');
        });
    }
    
    protected function insertComponentSlot($slotPosition, $slotNode, $i = 0)
    {
        $nodeData = Helper::nodeStdClass($slotNode->childNodes->item(0) ?? $slotNode);
        //$this->codebuffer->nestedExpression($nodeData->statements, function() use ($nodeData, $slotNode, $slotPosition, $i) {
            $name = $isComponent = Helper::isComponent($slotNode);
            $name = $name ? $name : $this->name.'_slot_'.$slotPosition.'?id='.uniqid();
 
            // ->addSlot()
            //dd($nodeData, $slotNode->childNodes-);
            $this->codebuffer->slot($i, $slotPosition, $name, $nodeData->attributes);
            if (!isset($this->document->templates[$name])) {
                (new Parser($this->document, $name))->parse($isComponent ? null : $slotNode);
                //TODO: data here
            }
            if ($slotNode->nodeName !== '#text') {
                //$slotNode->removeAttribute('slot');
            }
            
            if ($isComponent) {
                $slots = $this->getNodeSlots($slotNode);
                foreach ($slots as $slotPosition => $slotNodes) {
                    foreach ($slotNodes as $slotNode) {
                        $this->insertComponentSlot($slotPosition, $slotNode, $i+1);
                    }
                }
            } else {
                $next = $i+1; // anticipam urmatoarea variabila pentru 
                $this->codebuffer->raw("\$this->comp[{$next}]->setSlots(\$slots);");
            }
        //});
    }
}