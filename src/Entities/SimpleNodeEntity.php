<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Closure;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Dom\DomNodeAttr;

class SimpleNodeEntity extends AbstractEntity
{
    //protected $isHtml = true;
    protected $attrs = [];

    public static function test(DomNode $node, EntityInterface $context): bool
    {
        return true;
    }

    /**
     * <tpl><div></div></tpl>
     */
    public function anonymousContext()
    {
        return $this->simpleNodeContext();
    }

    /**
     * <div><div></div></div>
     */
    public function simpleNodeContext()
    {
        // TODO: test comp as simple text
        $data = $this->depleteNode($this->node);
        foreach ($this->node->childNodes as $slot) {
            $this->factory->make($slot, $this)->parse();
        }

        $this->node->addAttribute($data);
    }

    /**
     * <tpl extends="comp/x"><div></div></tpl>
     */
    public function extendContext()
    {
        $this->templateContext();
    }

    /**
     * <tpl is="comp/x"><div></div></tpl>
     */
    public function templateContext()
    {
        $data = $this->depleteNode($this->node);
        $this->node->addAttribute($data);

        foreach ($this->node->childNodes as $cn) {
            $this->factory->make($cn, $this)->parse();
        }

        $attrs = [];
        foreach ($this->attrs as $k => $val) {
            $attrs[] = new DomNodeAttr($k, $val); //todo, vezi daca e necesar
        }
        //$dataString = $this->fillNode(null, $attrs);
        //TODO: findout what to do with data
    }

    /**
     * <slot><div></div></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <div></div> -> when we call template->makeRaw('<div></div>');
     */
    public function startupContext()
    {

        $this->simpleNodeContext();

        /** @var StartupEntity */
        $context = $this->context;
        if ($name = $context->getName()) {
            $fnSrc = (string)$this->buildTemplateFunction($this->node);

            $fn = Closure::fromSource(new Source($fnSrc, ''), 'namespace PhpTemplates;');

            $this->cache->set($context->getName(), $fn, new Source($fnSrc, ''));
        }
    }

    /**
     * Never reached
     */
    public function textNodeContext()
    {}

    /**
     * Never reached
     */
    public function verbatimContext()
    {}
}
