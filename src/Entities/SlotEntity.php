<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNodes\PhpNode;

class SlotEntity extends AbstractEntity
{
    const WEIGHT = 80;

    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public static function test(DomNode $node, EntityInterface $context): bool
    {
        return $node->nodeName == 'slot';
    }

    /**
     * <div><slot></slot></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node->changeNode('#slot'); // prevent rendering the node as it is
        if ($this->hasSlotDefault) {
            $wrapperDefault = new DomNode('#slot');
            foreach ($this->node->childNodes as $cn) {
                $wrapperDefault->appendChild($cn->detach());
            }
            $this->node->appendChild($wrapperDefault);
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $wrapperDefault->setAttribute('p-if', $if);

            $this->factory->make($wrapperDefault, $this->context)->parse();
        }

        $append = new PhpNode('foreach', '$this->slots("' . $this->attrs['name'] . '") as $slot');
        // todo: solve this hack
        $r = '($slot)(' . $dataString . ')';
        $append->appendChild(new DomNode('#php', '<?php ' . $r . '; ?>'));
        $this->node->appendChild($append);
    }

    /**
     * Never reached
     */
    public function slotContext()
    {}

    /**
     * <tpl is="comp/x"><slot></slot></tpl>
     */
    public function templateContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['name'] = 'default';

        // mime like we have a simple node as component slot containing a slot node too
        $wrapper = new DomNode('#slot');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');

        $this->factory->make($wrapper, $this->context)->parse();
    }

    /**
     * <tpl extends="comp/x"><slot></slot></tpl>
     */
    public function extendContext()
    {
        $this->templateContext();
    }

    /**
     * <tpl><slot></slot></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * Never reached
     */
    public function verbatimContext()
    {}

    /**
     * Never reached
     */
    public function textNodeContext()
    {}

    public function resolve(CacheInterface $cache, EventHolder $eventHolder)
    {
        $this->hasSlotDefault = count($this->node->childNodes) > 0;
    }
}
