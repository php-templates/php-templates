<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class SimpleNode extends AbstractEntity
{
    protected $attrs = [];

    public function simpleNodeContext()
    {
        $this->templateContext();
    }
    
    public function templateContext()
    {
        $data = $this->depleteNode($this->node, true, true);
        foreach ($data as $k => $val) {
            //if ($this->node->nodeName === 'textarea') dd($data);
            $this->node->setAttribute($k, $val);
        }
        
        foreach ($this->childNodes($this->node) as $slot)
        {
            $this->parseNode($slot);
        }
    }

    public function componentContext()
    {
        parent::makeCaret();
        $this->attrs['slot'] = 'default';

        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);

        $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
        (new Template($this->document, $this->node, $name))->newContext();

        $this->println(
            sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s));', 
            $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString)
        );
    }
    
    public function blockContext()
    {
        parent::makeCaret();

        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);

        $name = $this->context->name .'?slot='.Helper::uniqid();
        (new Template($this->document, $this->node, $name))->newContext();

        $this->println(
            sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots));', 
            $this->depth, $this->context->depth, $this->context->name, $name, $dataString)
        );
    }
    
    protected function makeCaret($txt = '') {
        $this->caret = $this->node;
    }

    public function slotContext()
    {
        $this->node = $this->node->cloneNode(true);
        parent::makeCaret();

        $data = $this->depleteNode($this->node, false, true);
        foreach ($data as $k => $val) {
            //if ($this->node->nodeName === 'textarea') dd($data);
            $this->node->setAttribute($k, $val);
        }
        
        foreach ($this->childNodes($this->node) as $slot)
        {
            $this->parseNode($slot);
        }

        $this->println('; ?>');
        $this->println('<?php ;', 'after');
        $this->caret->parentNode->insertBefore($this->node, $this->caret);
    }
}