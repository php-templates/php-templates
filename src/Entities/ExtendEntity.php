<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Registry;

class ExtendEntity extends TemplateEntity
{
    protected $className;

    protected $attrs = [
        'template' => null,
        'is' => null,
        'extends' => null,
    ];


    public function __construct(Registry $registry, DomNode $node, AbstractEntity $context)
    {
        $this->node = $node;
        $this->context = $context;
        $this->registry = $registry;
        $this->id = uniqid();
        
        $name = $node->getAttribute('extends');
        
        $template = $this->cache->has($name);
        if (!$template) {
            $template = $this->parseTemplate($name);
        }
        
        $this->className = $template['class']->getName();
    }

    /**
     * <div><tpl extends="comp/x"></tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString(); // -> can t bind explicit data to extends, because it shares same context,…  use tpl instead…  so what… 

        $nodeValue = sprintf(
            '<?php $this->comp["%s"] = new %s($this->registry, $this->context->merge('.$dataString.')); ?>',
            $this->id,
            $this->className
        );
        $this->node->changeNode('#php', '');
        $slots = $this->parseSlots($this->node);
        $this->node->appendChild(new DomNode('#php', $nodeValue));

        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            $this->parser->make($slot, new StartupEntity($this->getConfig()))->parse();
        }

        $nodeValue = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $nodeValue));
    }

// legacy
    public function resolve(CacheInterface $document, EventHolder $eventHolder)
    {
        $this->node->setAttribute('is', $this->node->getAttribute('extends'));

        parent::resolve($document, $eventHolder);
    }
}
