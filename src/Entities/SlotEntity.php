<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\ViewParser;
use PhpTemplates\Config;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\InvalidNodeException;

class SlotEntity extends AbstractEntity
{
    const WEIGHT = 80;
    
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public static function test(DomNode $node, EntityInterface $context)
    {
        return $node->nodeName == 'slot';
    }

    public function simpleNodeContext()
    {
        //$wrapper = new DomNode('#slot');
        //$this->node->parentNode->insertBefore($wrapper, $this->node);
        //$wrapper->appendChild($this->node->detach());
        
        $data = $this->depleteNode($this->node); // am pus structuri de if
        $dataString = $data->toArrayString();
        //d($this->node->parentNode->parentNode->debug());
        //$dataString = Helper::arrayToEval($data);

        $this->node->changeNode('#slot'); // prevent rendering tag
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
        
        $append = new PhpNode('foreach', '$this->slots("'.$this->attrs['name'].'") as $slot');
        // todo: solve this hack
        $r = '($slot)('.$dataString.')';
        $append->appendChild(new DomNode('#php', '<?php ' . $r . '; ?>'));
        $this->node->appendChild($append);
        //d($this->node->parentNode->parentNode->debug());
        //$wrapper->dd();
    }

    public function slotContext()
    {
        // nu va ajunge niciodata aici
    }

    /**
     * <myComp><slot name="mytitle" slot="title"></slot></myComp>
     *
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
    
    public function anonymousContext() {
        $this->simpleNodeContext();
    }

    public function resolve(CacheInterface $cache, EventHolder $eventHolder) 
    {
        $this->hasSlotDefault = count($this->node->childNodes) > 0;
    }
}