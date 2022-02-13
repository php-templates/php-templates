<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class Block extends AbstractEntity
{
    protected $attrs = ['name' => null];

    protected $name;

    public function __construct(Document $doc, $node, AbstractEntity $context = null)
    {
        parent::__construct($doc, $node, $context);
        //todo: set name with throw error
        $this->name = $node->getAttribute('name');
    }

    /**
     * When a block is passed as a component slot
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        $this->println(
            sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("***block", %s)->withName("%s")->setSlots($this->slots));', 
            $this->depth, 
            $this->context->depth, 
            $this->attrs['slot'], 
            $dataString,
            $this->name
            )
        );
        foreach ($this->childNodes() as $i => $slot) {
            // register block defaults 
            if (!method_exists($slot, 'setAttribute')) {
                $_slot = $slot->ownerDocument->createElement('template');
                $_slot->appendChild($slot);
                $slot = $_slot;
            }
            $slot->setAttribute('_index', $i+1);
            $this->parseNode($slot);
        }
    }
    
    public function simpleNodeContext()
    {
        $phpStart = $this->controlStructures ? '' : '';
        $phpEnd = $this->controlStructures ? '' : '';

        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        $this->println(
            sprintf('%s $this->comp[%d] = Parsed::template("***block", %s)->withName("%s")->setSlots($this->slots);', 
            $phpStart,
            $this->depth, 
            $dataString,
            $this->name
            )
        );
        foreach ($this->childNodes() as $i => $slot) {
            // register block defaults 
            if (!method_exists($slot, 'setAttribute')) {
                $_slot = $slot->ownerDocument->createElement('template');
                $_slot->appendChild($slot);
                $slot = $_slot;
            }
            $slot->setAttribute('_index', $i+1);
            $this->parseNode($slot);
        }

        $this->println(
            sprintf('$this->comp[%d]->render($this->data); %s', $this->depth, $phpEnd)
        );

        $this->document->toberemoved[] = $this->node;
    }

    public function blockContext()
    {
        $this->node->setAttribute('slot', $this->context->name);$this->x = 1;
        $this->componentContext();
    }
}