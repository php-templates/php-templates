<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Process;

class ExtendEntity extends TemplateEntity
{
    const WEIGHT = 101;

    protected $attrs = [
        'template' => null,
        'is' => null,
        'extends' => null,
    ];

    public static function test(DomNode $node, EntityInterface $context): bool
    {
        return $node->nodeName == 'tpl' && $node->hasAttribute('extends');
    }

    public function __construct(DomNode $node, EntityInterface $context, Process $process)
    {
        $this->node = $node;
        $this->context = $context;
        $this->process = $process;
        $this->id = uniqid();
        
        $this->name = $node->getAttribute('extends');
        
        list($rfilepath, $config) = \PhpTemplates\parse_path($this->name, $process->config);
        
        $process->subprocess($rfilepath, $config)->run();
    }

    /**
     * <div><tpl extends="comp/x"></tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        // $dataString = $data->toArrayString(); -> can t bind explicit data to extends, because it shares same context, use tpl instead

        $nodeValue = sprintf(
            '<?php $this->comp["%s"] = $this->template("%s", $context); ?>',
            $this->id,
            $this->name
        );
        $this->node->changeNode('#php', '');
        $slots = $this->parseSlots($this->node);
        $this->node->appendChild(new DomNode('#php', $nodeValue));

        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            AbstractEntity::make($slot, new StartupEntity($this->process->config), $this->process)->parse();
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
