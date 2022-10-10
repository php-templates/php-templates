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
        $this->node->changeNode('#php', '');
        $slots = $this->parseSlots($this->node);
        $this->node->appendChild(new DomNode('#php', $nodeValue));

        foreach ($slots as $slot) {
            // todo ultimele modificari vor face templatecontext+derivate unreachable pe orice entity
            $this->node->appendChild($slot);
            $this->factory->make($slot, new StartupEntity($this->config))->parse();
        }

        $nodeValue = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $nodeValue));
    }
    
    public function resolve(CacheInterface $document, EventHolder $eventHolder)
    {
        $this->node->setAttribute('is', $this->node->getAttribute('extends'));
        
        parent::resolve($document, $eventHolder);
    }
}