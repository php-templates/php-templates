<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;

class ExtendEntity extends TemplateEntity
{
    const WEIGHT = 101;
    
    protected $attrs = [
        'template' => null,
        'is' => null,
        'extends' => null,
    ];
    
    public static function test(DomNode $node, EntityInterface $context)
    {
        return $node->nodeName == 'tpl' && $node->hasAttribute('extends');
    }

    public function simpleNodeContext() 
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $nodeValue = sprintf('<?php $this->comp["%s"] = $this->template("%s", $context); ?>',
            $this->id, $this->name
        );
        $this->node->changeNode('#php', $nodeValue);

        foreach ($this->node->childNodes as $slot) {
            //todo: grupam dupa slots o fn ceva?
            $this->factory->make($slot, $this)->parse();
        }

        $r = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $r));
    }
    
    public function resolve(CacheInterface $document, EventHolder $eventHolder)
    {
        $this->node->setAttribute('is', $this->node->getAttribute('extends'));
        
        parent::resolve($document, $eventHolder);
    }
}