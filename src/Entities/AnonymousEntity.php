<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\WrapperNode;

/**
 * <tpl>...</tpl>
 */
class AnonymousEntity extends Entity
{
    public function startupContext() {
        $this->simpleNodeContext();
    }
    
    /**
     * <div><tpl>...</tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $this->node->setNodeName('');

        foreach ($this->node->getChildNodes() as $cn) {
            $this->child($cn)->startupContext();
        }
        $data->addToNode($this->node);
    }

    /**
     * <tpl is="comp/x"><tpl>...</tpl></tpl>
     */
    public function templateContext()
    {
        $this->attrs['slot'] = 'default';

        $wrapper = new DomNode('tpl');
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');
        $wrapper->insertBefore($this->node);
        $wrapper->appendChild($this->node->detach());

        $this->child($wrapper)->startupContext();
    }

    /**
     * <tpl extends="comp/x"><tpl>...</tpl></tpl>
     */
    public function extendContext()
    {
        $this->templateContext();
    }

    /**
     * <slot><tpl>...</tpl></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <tpl><tpl>...</tpl></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext();
    }
}
