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
        $this->templateFunctionContext();
    }

    public function templateContext()
    {
        return $this->templateFunctionContext();
    }

    public function templateFunctionContext()
    {
        /*$this->isHtml = true; TODO: comp as simple text
        if (!$this->node->parentNode) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            return;
        }
*/
        //d('avi'. $this->caret->parentNode);
        /*$node = @$this->node->cloneNode(true); TODO: FINDOUTa
        //d('avi'. $this->caret->parentNode);
        if ($node && method_exists($this->caret->parentNode, 'insertBefore')) {
            $this->removeNode($this->node);
            $this->node = $node;
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
        }*/

        $this->depleteNode($this->node, function($data, $c_structs) {
            if (0/* $node || $this->caret->parentNode->ownerDocument*/) {
                    //$this->caret->parentNode->inseerBefore($this->node, $this->caret);
                $this->caret->parentNode->insertBefore($this->node->detach(), $this->caret);
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

            (new TemplateFunction($this->process, $this->node, $name))->parse();
            $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));

            $slot = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots)); ?>', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString
            );
            $this->node->changeNode('#slot', $slot);
            $this->node->empty();
        });
    }
    
    public function blockContext()
    {
        $this->attrs['_index'] = 0;
        $GLOBALS['x'] = $this->node->getAttribute('class') == 'row';
        $this->depleteNode($this->node, function($data) {
            $this->fillNode($this->node, $data);
            //if ($GLOBALS['x']) dd($this->attrs, $data);
            $dataString = Helper::arrayToEval($this->attrs);
            $name = $this->context->name .'?slot='.Helper::uniqid();
            //$node = new DomNode('#root'); //pierde atributele daca e simple node... trebuie fill de aici
            //$node->appendChild($this->node->detach());
            (new TemplateFunction($this->process, $this->node, $name))->parse();
    
            $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots)); ?>', 
                $this->depth, $this->context->depth, $this->context->name, $name, $dataString
            );
            $this->node->changeNode('#php', $r);
            $this->node->empty();
            //dd(''.$this->node->parentNode);
        });
    }

    /**
     * as slot default
     */
    public function slotContext()
    {
        $this->isHtml = true;
        //$this->node = $this->node->cloneNode(true);
        // close php
        $this->depleteNode($this->node, function($data) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            //$this->caret->parentNode->insertBefore($this->node, $this->caret);
        });
    }
}