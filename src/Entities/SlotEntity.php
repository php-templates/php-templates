<?php

namespace PhpTemplates\Entities;

use PhpDom\DomNode;
use PhpTemplates\Parser;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\Registry;

class SlotEntity extends Entity
{
    protected array $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;
    
    public function __construct(Parser $parser, DomNode $node, Entity $context)
    {
        parent::__construct($parser, $node, $context);
        
        $this->hasSlotDefault = $this->node->getChildNodes()->count() > 0;
    }

    /**
     * <div><slot></slot></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node = $this->replaceNode($this->node, new WrapperNode);
        if ($this->hasSlotDefault) {
            $wrapperDefault = new DomNode('tpl');
            foreach ($this->node->getChildNodes() as $cn) {
                $wrapperDefault->appendChild($cn->detach());
            }
            $this->node->appendChild($wrapperDefault);
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $wrapperDefault->setAttribute('p-if', $if);

            $this->child($wrapperDefault)->parse();
        }

        $append = new PhpNode('foreach', '$this->slots("' . $this->attrs['name'] . '") as $slot');
        $r = '$slot->render(' . $dataString . ')';
        $append->appendChild(new PhpNode('', $r));
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
    {// when slot default, never come here, bcz templateentity
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node = $this->replaceNode($this->node, new WrapperNode); // prevent rendering the node as it is

        $append = new PhpNode('if', '$this->slots("' . $this->attrs['name'] . '")');
        $assign = sprintf('$this->comp["%s"]->setSlot("%s", $this->slots("%s"))', $this->context->getId(), $this->attrs['slot'], $this->attrs['name']);
        $append->appendChild(new PhpNode('', $assign));
        $this->node->appendChild($append);        
    }

    /**
     * <tpl extends="comp/x"><slot></slot></tpl>
     */
    public function extendContext()
    {
        // unreachable because of View::simpleNodeContext dom manipulation
    }

    /**
     * <tpl><slot></slot></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext($parser);
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
}
