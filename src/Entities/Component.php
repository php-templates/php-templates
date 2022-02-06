<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class Component extends AbstractEntity
{
    protected $attrs = ['is' => null];

    public function __construct(Document $doc, $node, AbstractEntity $context)
    {
        parent::__construct($doc, $node, $context);
        $this->name = Helper::isComponent($this->node);
    }

    public function simpleNodeContext()
    {
        $this->templateContext();
    }
    
    public function templateContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        (new Template($this->document, $this->name))->newContext();

        $definition = '<?php $this->comp[%d] = Parsed::template("%s", %s);';
        $this->println(
            sprintf($definition, $this->depth, $this->name, $dataString)
        );
        
        foreach ($this->node->childNodes as $slot)
        {
            $this->parseNode($slot);
        }
        
        $definition = '$this->comp[%d]->render($this->data); ?>';
        $this->println(
            sprintf($definition, $this->depth)
        );
    }

    /**
     * When a component is passed as slot to another component
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $dataString = Helper::arrayToEval($this->depleteNode($this->node));
        (new Template($this->document, $this->name))->newContext();

        $definition = '$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s))';
        $this->println(
            sprintf($definition, $this->depth, $this->context->depth, $this->attrs['slot'], $this->name, $dataString)
        );
        
        foreach ($this->node->childNodes as $slot)
        {
            $this->parseNode($slot);
        }
    }

    /**
     * When a component is passed as slot default
     */
    public function slotContext()
    {

    }





    public function mount($i = 0): void
    {
        // deplete node
        // will fill attrs
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        if (!isset($this->document->templates[$this->name])) {
            (new Parser($this->document, $this->name))->parse();
        }
        
        if ($i) {
            // insert as slot
            $next = $i +1;
            $decl = "\$this->comp[$next] = \$this->comp[$i]->addSlot($this->slotPos, Parsed::template($this->name, $dataString);";
        } else {
            $decl = "\$this->comp[0] = Parsed::template($this->name, $dataString);";
        }
        $decl = $node->ownerDocument->createTextNode($decl);
        $this->node->parentNode->insertBefore($this->node, $refNode);
        $this->document->toberemoved[] = $node;
        
        // insert slots
        foreach ($node->childNodes as $slot) {
            // move node outside to not be deleted its surroundings when parent node is removed
            $slot = $slot->cloneNode(true);
            $node->parentNode->insertBefore($node, $slot);
            NodeParser::parse($slot, $i +1);
        }
        
        // render only when root
        if (!$i) {
            $this->node->parentNode->insertBefore(
                $this->node, 
                $node->ownerDocument->createTextNode('$this->comp[0]->render($data)')
            );
        }
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