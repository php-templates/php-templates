<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\Closure;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Dom\DomNodeAttr;
use PhpTemplates\Dom\PhpSlotAssignNode;

class SimpleNodeEntity extends AbstractEntity
{
    //protected $isHtml = true;
    protected $attrs = [];

    public static function test(DomNode $node, EntityInterface $context)
    {
        return true;
    }

    public function anonymousContext()
    {
        return $this->simpleNodeContext();
    }

    public function simpleNodeContext()
    {
        // TODO: comp as simple text
        $data = $this->depleteNode($this->node);
        foreach ($this->node->childNodes as $slot) {
            $this->factory->make($slot, $this)->parse();
        }

        $this->node->addAttribute($data);
    }
    
    public function extendContext() {
        $this->templateContext();
    }

    public function templateContext()
    {
        $this->attrs['slot'] = 'default';
        $scopeData = $this->context->getAttr('p-scope');

        $slotAssignNode = new PhpSlotAssignNode($this->context->getId(), $this->node->getAttribute('slot') ?? 'default', $scopeData);
        $this->node->parentNode->insertBefore($slotAssignNode, $this->node);
        $slotAssignNode->appendChild($this->node->detach());

        $data = $this->depleteNode($this->node);
        $this->node->addAttribute($data);

        foreach ($this->node->childNodes as $cn) {
            $this->factory->make($cn, $this)->parse();
        }
        
        $attrs = [];
        foreach ($this->attrs as $k => $val) {
            $attrs[] = new DomNodeAttr($k, $val);//todo, vezi daca e necesar
        }
        //$dataString = $this->fillNode(null, $attrs);
//TODO: findout what to do with data
    }

    /**
     * as slot default
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }
    
    public function startupContext() {
        
        $this->simpleNodeContext();

        $fnSrc = $this->buildTemplateFunction($this->node);

        $fn = Closure::fromSource(new Source($fnSrc, ''), 'namespace PhpTemplates;');
        /** @var StartupEntity */
        $context = $this->context;

        $this->cache->set($context->getName(), $fn, new Source($fnSrc, ''));
    }
}