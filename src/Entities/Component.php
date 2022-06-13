<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Process;
use PhpTemplates\Dom\DomNode;

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
        $data = $this->depleteNode($this->node);
        $data = $this->fillNode(null, $data);

        $dataString = Helper::arrayToEval($data);
        (new TemplateFunction($this->process, $this->name, $this->context))->parse();

        $nodeValue = sprintf('<?php $this->comp[%d] = Parsed::template("%s", %s); ?>', 
            $this->depth, $this->name, $dataString
        );      
        $this->node->changeNode('#php', $nodeValue);

        foreach ($this->node->childNodes as $slot) {
            $this->parseNode($slot);
        }

        $r = sprintf('<?php $this->comp[%d]->render($this->scopeData); ?>', $this->depth);
        $this->node->appendChild(new DomNode('#php', $r));
    }

    /**
     * When a component is passed as slot to another component
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $data = $this->depleteNode($this->node);
        $data = $this->fillNode(null, $data);   
        $dataString = Helper::arrayToEval($data);
        (new TemplateFunction($this->process, $this->name, $this->context))->parse();

        $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)); ?>', 
            $this->depth, $this->context->depth, $this->attrs['slot'], $this->name, $dataString
        );
        $this->node->changeNode('#php', $r);
        
        foreach ($this->node->childNodes as $slot)
        {
            $this->parseNode($slot);
        }
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