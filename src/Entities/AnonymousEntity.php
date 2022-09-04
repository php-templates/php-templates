<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Helper;
use PhpTemplates\Dom\DomNode;

/**
 * is actually component, but used in different contexts, even on root
*/
class AnonymousEntity extends AbstractEntity
{
    const WEIGHT = 90;
    
    protected $attrs = [];

    public static function test(DomNode $node, EntityInterface $context)
    {
        return $node->nodeName == 'template';
    }

    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $this->node->changeNode('#template');
        foreach ($this->node->childNodes as $cn) {
            $this->factory->make($cn, $this)->parse();
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
        
        $this->factory->make($wrapper, $this->context)->parse();
    }
    
    public function slotContext() {
        $this->simpleNodeContext();
    }

    public function anonymousContext() {
        $this->simpleNodeContext();
    }
}