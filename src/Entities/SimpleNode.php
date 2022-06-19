<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Dom\DomNode;
use IvoPetkov\HTML5DOMDocument;

class SimpleNode extends AbstractEntity
{
    //protected $isHtml = true;
    protected $attrs = [];

    public function simpleNodeContext()
    {
        $this->rootContext();
    }

    public function templateContext()
    {
        return $this->rootContext();
    }

    public function rootContext()
    {
        // TODO: comp as simple text
        $data = $this->depleteNode($this->node);
        foreach ($this->node->childNodes as $slot) {
            $this->parseNode($slot);
        }

        $this->fillNode($this->node, $data);
    }

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['_index'] = 0;

        $data = $this->depleteNode($this->node);
        $this->fillNode($this->node, $data);
        $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();

        (new Root($this->process, $this->node, $name))->rootContext();
        $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));

        $slot = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots)); ?>', 
            $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString
        );
        $this->node->changeNode('#slot', $slot);
        $this->node->empty();
    }
    
    public function blockContext()
    {
        $this->attrs['_index'] = 0;

        $data = $this->depleteNode($this->node);
        $this->fillNode($this->node, $data);

        $dataString = Helper::arrayToEval($this->attrs);
        $name = $this->context->name .'?slot='.Helper::uniqid();

        (new TemplateFunction($this->process, $this->node, $name))->parse();

        $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots)); ?>', 
            $this->depth, $this->context->depth, $this->context->name, $name, $dataString
        );
        $this->node->changeNode('#php', $r);
        $this->node->empty();
    }

    /**
     * as slot default
     */
    public function slotContext()
    {
        $data = $this->depleteNode($this->node);
        foreach ($this->node->childNodes as $slot) {
            $this->parseNode($slot);
        }
        $this->fillNode($this->node, $data);
    }
}