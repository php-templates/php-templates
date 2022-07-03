<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\Process;
use PhpTemplates\InvalidNodeException;
use PhpTemplates\Dom\DomNode;

class Block extends AbstractEntity
{
    protected $attrs = ['name' => null];

    protected $name;

    public function __construct(Process $process, $node, AbstractEntity $context = null)
    {
        parent::__construct($process, $node, $context);
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
        $data = $this->fillNode(null, $data);
        $dataString = Helper::arrayToEval($data);
        
        $nodeValue = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("***block", %s)->withName("%s")->withData($this->scopeData)->setSlots($this->slots)); ?>', 
            $this->depth, 
            $this->context->depth, 
            $this->attrs['slot'], 
            $dataString,
            $this->name
        );
        $this->node->changeNode('#block', $nodeValue);
        
        foreach ($this->node->childNodes as $i => $slot) {
            // register block defaults 
            if (0&&!method_exists($slot, 'setAttribute')) {
                $_slot = new DomNode('template');
                $_slot->appendChild($slot->detach());
                $slot = $_slot;
            }
            $slot->setAttribute('_index', $i+1);
            $this->parseNode($slot);
        }
    }
    
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $data = $this->fillNode(null, $data);
        $dataString = Helper::arrayToEval($data);

        $nodeValue = sprintf('<?php $this->comp[%d] = Parsed::template("***block", %s)->withName("%s")->withData($this->scopeData)->setSlots($this->slots); ?>', 
            $this->depth, 
            $dataString,
            $this->name
        );
        $this->node->changeNode('#block', $nodeValue);
        
        foreach ($this->node->childNodes as $i => $slot) {
            // register block defaults // TODO:
            if (0&&!method_exists($slot, 'setAttribute')) {
                $_slot = $slot->ownerDocument->createElement('template');
                $_slot->appendChild($slot);
                $slot = $_slot;
            }
            $slot->setAttribute('_index', $i+1);
            $this->parseNode($slot);
        }

        $r = sprintf('<?php $this->comp[%d]->render($this->scopeData); ?>', $this->depth);
        $this->node->appendChild(new DomNode('#php', $r));
    }
    
    public function rootContext()
    {
        return $this->simpleNodeContext();
    }

    public function blockContext()
    {
        $this->node->setAttribute('slot', $this->context->name);
        $this->componentContext();
    }
    
    public function slotContext() {
        throw new InvalidNodeException('Block cannot be used inside a slot', $this->node);
    }
    public function templateContext() {
        $this->simpleNodeContext();
    }
}