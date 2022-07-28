<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Helper;
use PhpTemplates\Dom\DomNode;

/**
 * is actually component, but used in different contexts, even on root
*/
class Template extends AbstractEntity
{
    protected $attrs = [];

    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $this->node->changeNode('#template');
        foreach ($this->node->childNodes as $cn) {
            $this->parser->parseNode($cn, $this->config, $this);
        }
        $this->fillNode($this->node, $data);
    }

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        
        $wrapper = new DomNode('#slot');
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());
        
        $this->parser->parseNode($wrapper, $this->config, $this->context);
        return;
        
        //$data = $this->depleteNode($this->node);
        //$this->fillNode($this->node, $data);

        $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
        $node = new DomNode('#root');
        foreach ($this->node->childNodes as $cn) {
            $node->appendChild($cn->detach());
        }
        
        (new Root($this->process, $node, $name, $this->context))->rootContext();
        $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));
        $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", $this->template("%s", %s)->withData($this->scopeData)->setSlots($this->slots)); ?>', 
            $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString
        );
        $this->node->changeNode('#pho', $r);
    }
    
    public function rootContext() {
        $this->simpleNodeContext();
    }
    public function slotContext() {
        $this->simpleNodeContext();
    }
    public function blockContext() {
        throw new InvalidNodeException('Template tag is not allowed as block child', $this->node->parentNode);
    }
    public function templateContext() {
        $this->simpleNodeContext();
    }
}