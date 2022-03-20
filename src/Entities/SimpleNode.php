<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use IvoPetkov\HTML5DOMDocument;

class SimpleNode extends AbstractEntity
{
    //protected $isHtml = true;
    protected $attrs = [];

    public function simpleNodeContext()
    {
        $this->templateFunctionContext();
    }

    public function templateContext()
    {
        return $this->templateFunctionContext();
    }

    public function templateFunctionContext()
    {
        if (!$this->node->parentNode) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            return;
        }

        $node = @$this->node->cloneNode(true);
        if ($node && method_exists($this->caret->parentNode, 'insertBefore')) {
            $this->removeNode($this->node);
            $this->node = $node;
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
        }

        $this->depleteNode($this->node, function($data, $c_structs) use ($node) {
            if ($node/* || $this->caret->parentNode->ownerDocument*/) {
                    //$this->caret->parentNode->inseerBefore($this->node, $this->caret);
                $this->caret->parentNode->insertBefore($this->node, $this->caret);
                
            }
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }

            $this->fillNode($this->node, $data);
        });
    }

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['_index'] = 0;

        $this->depleteNode($this->node, function($data) {
            $this->fillNode($this->node, $data);
            $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
            $node = new HTML5DOMDocument;
  
            $node->appendChild($node->importNode($this->node, true));
            (new TemplateFunction($this->process, $node, $name))->parse();
    
            $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));

            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots));', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString)
            );
        });
    }
    
    public function blockContext()
    {
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.Helper::uniqid();
            $node = new HTML5DOMDocument;
            $node->appendChild($node->importNode($this->node, true));
            (new TemplateFunction($this->process, $node, $name))->parse();
    
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots));', 
                $this->depth, $this->context->depth, $this->context->name, $name, $dataString)
            );
        });
    }

    /**
     * as slot default
     */
    public function slotContext()
    {
        $this->isHtml = true;
        $this->node = $this->node->cloneNode(true);
        // close php
        $this->depleteNode($this->node, function($data) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
        });
    }

    public function anonymousComponentContext()
    {
        $this->slotContext();
    }
}