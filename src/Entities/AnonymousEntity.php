<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Helper;
use PhpTemplates\Dom\DomNode;

/**
 * <tpl>...</tpl>
 */
class AnonymousEntity extends AbstractEntity
{
    const WEIGHT = 90;

    protected $attrs = [];

    public static function test(DomNode $node, EntityInterface $context): bool
    {
        return $node->nodeName == 'tpl';
    }

    /**
     * <div><tpl>...</tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $this->node->changeNode('#template');
        foreach ($this->node->childNodes as $cn) {
            AbstractEntity::make($cn, $this, $this->process)->parse();
        }
        $data->addToNode($this->node);
    }

    /**
     * <tpl is="comp/x"><tpl>...</tpl></tpl>
     */
    public function templateContext()
    {
        $this->attrs['slot'] = 'default';

        $wrapper = new DomNode('#slot');
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());

        $this->factory->make($wrapper, $this->context)->parse();
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

    /**
     * never reached
     */
    public function textNodeContext()
    {
    }


    /**
     * never reached
     */
    public function verbatimContext()
    {
    }
}
