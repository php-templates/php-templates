<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\Process;

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

        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
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
        });
    }
    
    public function simpleNodeContext()
    {
        $this->depleteNode($this->node, function($data) {
            //$this->node->setAttribute('x',33);
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
    
            $this->println(
                sprintf('$this->comp[%d] = Parsed::template("***block", %s)->withName("%s")->setSlots($this->slots);', 
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
                sprintf('$this->comp[%d]->render($this->scopeData);', $this->depth)
            );
        });

        // remove now...
        $this->removeNode($this->node);
    }

    public function blockContext()
    {
        $this->node->setAttribute('slot', $this->context->name);
        $this->componentContext();
    }
}