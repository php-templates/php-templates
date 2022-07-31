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
            $this->parser->parseNode($slot, $this->config, $this);
        }

        $this->fillNode($this->node, $data);
    }

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['_index'] = 0;
        
        $root = new DomNode('#root');
        $this->node->parentNode->insertBefore($root, $this->node);
        $root->appendChild($this->node->detach());
//$this->node->parentNode->parentNode->dd();
        $data = $this->depleteNode($this->node);
        $this->fillNode($this->node, $data);
        //$name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();

        foreach ($this->node->childNodes as $cn) {
            $this->parser->parseNode($cn, $this->config, $this);
        }
        //dd($root->parentNode->dd());
        $fn = $this->parser->nodeToTemplateFunction($root, true);
        //(new Root($this->process, $this->node, $name))->rootContext();
        $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));
//TODO: findout what to do with data

        $slot = sprintf('<?php $this->comp["%s"]->addSlot("%s", %s); ?>', 
            $this->context->getId(), $this->attrs['slot'], $fn
        );
        
        $root->changeNode('#slot', $slot);
        $root->empty();
    }
    
    public function blockContext()
    {
        $this->attrs['_index'] = 0;

        $data = $this->depleteNode($this->node);
        $this->fillNode($this->node, $data);

        $dataString = Helper::arrayToEval($this->attrs);
        $name = $this->context->name .'?slot='.Helper::uniqid();

        (new Root($this->process, $this->node, $name))->rootContext();

        $r = sprintf('<?php $this->comp["%s"] = $this->comp["%s"]->addSlot("%s", $this->template("%s", %s)->withData($this->scopeData)->setSlots($this->slots)); ?>', 
            $this->id, $this->context->getId(), $this->context->name, $name, $dataString
        );
        $this->node->changeNode('#php', $r);
        $this->node->empty();
    }

    /**
     * as slot default
     */
    public function slotContext()
    {
        $this->rootContext();
        return;
        $data = $this->depleteNode($this->node);
        foreach ($this->node->childNodes as $slot) {
            $this->parser->parseNode($slot, $this->config, $this);
        }
        $this->fillNode($this->node, $data);
    }
}