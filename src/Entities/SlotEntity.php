<?php

namespace PhpTemplates\Entities;

use PhpDom\DomNode;
use PhpTemplates\Contracts\Entity as EntityInterface;
use PhpTemplates\Parser;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\Registry;

class SlotEntity extends Entity
{
    protected array $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;
    
    public function __construct(DomNode $node, EntityInterface $context)
    {
        parent::__construct($node, $context);
        
        $this->hasSlotDefault = $this->node->getChildNodes()->count() > 0;
    }
    
    public function startupContext() 
    {
        $this->simpleNodeContext();
    }

    /**
     * <div><slot></slot></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node->setNodeName('');
        if ($this->hasSlotDefault) {
            $wrapperDefault = new DomNode('tpl');
            foreach ($this->node->getChildNodes() as $cn) {
                $wrapperDefault->appendChild($cn->detach());
            }
            $this->node->appendChild($wrapperDefault);
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $wrapperDefault->setAttribute('p-if', $if);

            $this->child($wrapperDefault)->slotContext();
        }

        $append = new PhpNode('foreach', '$this->slots("' . $this->attrs['name'] . '") as $slot');
        $r = '$this->scope->slot->render(' . $dataString . ')';
        $append->appendChild(new PhpNode('', $r));
        $this->node->appendChild($append);
    }

    /**
     * <tpl is="comp/x"><slot></slot></tpl>
     */
    public function templateContext()
    {
        dd(3);
        // when slot default, never come here, bcz templateentity
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node->setNodeName('');
        $append = new PhpNode('if', '$this->slots("' . $this->attrs['name'] . '")');
        $assign = sprintf('$this->comp["%s"]->setSlot("%s", $this->slots("%s"))', $this->context->getId(), $this->attrs['slot'], $this->attrs['name']);
        $append->appendChild(new PhpNode('', $assign));
        $this->node->appendChild($append);        
    }

    /**
     * <tpl><slot></slot></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext($parser);
    }
}
