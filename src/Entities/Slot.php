<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Process;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\InvalidNodeException;

class Slot extends AbstractEntity
{
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public function __construct(Process $process, $node, AbstractEntity $context)
    {
        parent::__construct($process, $node, $context);

        $this->hasSlotDefault = count($this->node->childNodes) > 0;
    }

    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $data = $this->fillNode(null, $data);
        $dataString = Helper::arrayToEval($data);

        $this->node->changeNode('#slot');
        if ($this->hasSlotDefault) {
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $slotDefault = new PhpNode('if', $if);
            foreach ($this->node->childNodes as $cn) {
                // wrap cn into an empty node to not lose its condition structures on parsing process
                $wrapper = new DomNode('#wrapper');
                $wrapper->appendChild($cn->detach());
                $this->parseNode($cn);
                $slotDefault->appendChild($wrapper);
            }
            $this->node->appendChild($slotDefault);
        }
        
        $append = new PhpNode('foreach', '$this->slots("'.$this->attrs['name'].'") as $_slot');
        $r = '<?php $_slot->render('.$dataString.'); ?>';
        $append->appendChild(new DomNode('#php', $r));
        $this->node->appendChild($append);
    }

    public function slotContext()
    {
        throw new InvalidNodeException('Invalid slot location (slot in slot not allowed)', $this->node);
    }

    /**
     * <myComp><slot name="mytitle" slot="title"></slot></myComp>
     *
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['name'] = 'default';

        $data = $this->depleteNode($this->node);
        $data = $this->fillNode(null, $data);
        $dataString = Helper::arrayToEval($data);

        $this->node->changeNode('#slot');
        if ($this->hasSlotDefault) {
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $slotDefault = new PhpNode('if', $if);
            foreach ($this->node->childNodes as $cn) {
                $name = $this->attrs['name'] .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
                $node = new DomNode('#root');
                $node->appendChild($cn->detach());
                (new Root($this->process, $node, $name, $this->context))->rootContext();
                $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Template::template("%s", %s)); ?>', 
                    $this->depth, $this->context->depth, $this->attrs['slot'], $name, '[]'
                );
                $cn->changeNode('#php', $r);
                $cn->empty();
                $slotDefault->appendChild($cn->detach());
            }
            $this->node->appendChild($slotDefault);
        }
        
        $append = new PhpNode('foreach', '$this->slots("'.$this->attrs['name'].'") as $_slot');
        $r = sprintf('<?php $this->comp[%d]->addSlot("%s", $_slot); ?>',
            $this->context->depth, $this->attrs['slot']
        );
        
        $append->appendChild(new DomNode('#php', $r));
        $this->node->appendChild($append);
    }
    
    public function rootContext() {
        return $this->simpleNodeContext();
    }
    public function templateContext() {
        $this->simpleNodeContext();
    }
    public function blockContext() {
        throw new InvalidNodeException('Invalid slot location (slot in block not allowed)', $this->node->parentNode);
    }
}