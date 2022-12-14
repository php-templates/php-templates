<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNodes\PhpNode;
use PhpTemplates\Process;

class SlotEntity extends AbstractEntity
{
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;
    
    public function __construct(DomNode $node, AbstractEntity $context, Process $process)
    {
        parent::__construct($node, $context, $process);
        
        $this->hasSlotDefault = count($this->node->childNodes) > 0;
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

            AbstractEntity::make($wrapperDefault, $this->context, $this->process)->parse();
        }

        $append = new PhpNode('foreach', '$this->slots("' . $this->attrs['name'] . '") as $slot');
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
    {// when slot default, never come here, bcz templateentity
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node->changeNode('#slot'); // prevent rendering the node as it is

        $append = new PhpNode('if', '$this->slots("' . $this->attrs['name'] . '")');
        $assign = sprintf('$this->comp["%s"]->setSlot("%s", $this->slots("%s"))', $this->context->getId(), $this->attrs['slot'], $this->attrs['name']);
        $append->appendChild(new DomNode('#php', '<?php ' . $assign . '; ?>'));
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
}
