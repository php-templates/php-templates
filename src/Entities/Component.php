<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Process;

class Component extends AbstractEntity
{
    protected $attrs = ['is' => null];

    public function __construct(Process $process, $node, AbstractEntity $context)
    {
        parent::__construct($process, $node, $context);

        $this->name = $this->isComponent($this->node);
    }
    
    public function simpleNodeContext()
    {
        $this->templateFunctionContext();
    }
    
    public function templateFunctionContext()
    {
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);

            $dataString = Helper::arrayToEval($data);
            (new TemplateFunction($this->process, $this->name))->parse();
    
            $this->println(
                sprintf('$this->comp[%d] = Parsed::template("%s", %s);', $this->depth, $this->name, $dataString)
            );       
            foreach ($this->childNodes() as $slot) {
                $this->parseNode($slot);
            }
            //d($this->caret);
            $this->println(
                sprintf('$this->comp[%d]->render($this->scopeData);', $this->depth)
            );
        });

        $this->removeNode($this->node);
    }

    /**
     * When a component is passed as slot to another component
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);   
            $dataString = Helper::arrayToEval($data);
            (new TemplateFunction($this->process, $this->name))->parse();
    
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s));', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $this->name, $dataString)
            );
            
            foreach ($this->childNodes() as $slot)
            {
                $this->parseNode($slot);
            }
        });
    }

    /**
     * When component is passed as block default
     */
    public function blockContext()
    {
        $this->node->setAttribute('slot', $this->context->name);
        $this->componentContext();
    }

    /**
     * When a component is passed as slot default
     */
    public function slotContext()
    {
        $this->templateFunctionContext();
    }
}