<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Process;
use PhpTemplates\Config;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Dom\Parser;
use PhpTemplates\Closure;
use PhpTemplates\Dom\PhpNodes\SlotAssign;

class TemplateEntity extends AbstractEntity
{ // de documentat p-scope scos default $slot
    const WEIGHT = 100;
    
    private $subprocess;
    protected $name;
    protected $attrs = [
        'is' => null,
    ];

    public function __construct(DomNode $node, EntityInterface $context, Process $process)
    {
        parent::__construct($node, $context, $process);
        
        $name = $node->getAttribute('is');
        list($rfilepath, $config) = \PhpTemplates\parse_path($name, $process->config);
        if ($config->isDefault()) {
            $name = $rfilepath;
        }
        $this->name = $name;
        
        if (!$this->process->getCache()->has($name)) {
            $this->subprocess = $process->subprocess($rfilepath, $config);
        }
    }

    /**
     * <div><tpl is="comp/x"></tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $nodeValue = sprintf(
            '<?php $this->comp["%s"] = $this->template("%s", $_context->root()->subcontext(%s)); ?>',
            $this->id,
            $this->name,
            $dataString
        );
        $this->node->changeNode('#php', '');
        $slots = $this->parseSlots($this->node);
        $this->node->appendChild(new DomNode('#php', $nodeValue));

        foreach ($slots as $slot) {
            if (count($slot->childNodes) === 2 && $slot->childNodes[1]->nodeName == 'slot' && !$slot->childNodes[1]->childNodes) {
                $slot = $slot->childNodes[1]->detach();
                $this->node->appendChild($slot);
                AbstractEntity::make($slot, $this, $this->process)->parse();
            } else {
                $this->node->appendChild($slot);// only 1 slot and is slot node
                AbstractEntity::make($slot, new StartupEntity($this->process->config), $this->process)->parse();
            }
        }

        $nodeValue = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $nodeValue));
        
        $this->subprocess && $this->subprocess->run();
    }

    /**
     * Unreachable because of Dom manipulation in self::simpleNodeContext
     */
    public function templateContext()
    {
    }

    /**
     * Unreachable because of Dom manipulation in self::simpleNodeContext
     */
    public function extendContext()
    {
    }

    /**
     * <slot><tpl is="comp/x"></tpl></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <tpl><tpl is="comp/x"></tpl></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <tpl is="comp/x"></tpl> -> entry point of a normal parse
     */
    public function startupContext()
    {
        return $this->simpleNodeContext();
    }

    /**
     * Never reached
     */
    public function textNodeContext()
    {
    }

    /**
     * Never reached
     */
    public function verbatimContext()
    {
    }

    /**
     * Returns an associative array containing assigned component slots grouped under their positions
     *
     * @param DomNode $node
     * @return array
     */
    protected function parseSlots(DomNode $node): array
    {
        $slots = [];
        foreach ($node->childNodes as $cn) {
            $pos = $cn->getAttribute('slot');
            $cn->removeAttribute('slot');
            $pos = $pos ? $pos : 'default';
            if (!isset($slots[$pos])) {
                $slots[$pos] = new SlotAssign($this->id, $pos);
            }
            $slots[$pos]->appendChild($cn->detach());
        }
        
        return array_reverse($slots);
    }
}
