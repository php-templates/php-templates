<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\ViewParser;
use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\InvalidNodeException;

class Slot extends AbstractEntity
{
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public function __construct(ViewParser $parser, Config $config, DomNode $node, AbstractEntity $context)
    {
        parent::__construct($parser, $config, $node, $context);

        $this->hasSlotDefault = count($this->node->childNodes) > 0;
    }

    public function simpleNodeContext()
    {
        $wrapper = new DomNode('#slot');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());
        
        $data = $this->depleteNode($this->node);
        $dataString = $this->fillNode(null, $data);
        //$dataString = Helper::arrayToEval($data);

        $this->node->changeNode('#slot');
        if ($this->hasSlotDefault) {
            $wrapperDefault = new DomNode('#slot');
            foreach ($this->node->childNodes as $cn) {
                $wrapperDefault->appendChild($cn->detach());
            }
            $this->node->appendChild($wrapperDefault);
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $wrapperDefault->setAttribute('p-if', $if);
            //$slotDefault = new PhpNode('if', $if);
            $this->parser->parseNode($wrapperDefault, $this->config, $this->context);
            //foreach ($this->node->childNodes as $cn) {
                // wrap cn into an empty node to not lose its condition structures on parsing process
                //$wrapper = new DomNode('#wrapper');
                //$wrapper->appendChild($cn->detach());
                //$slotDefault->appendChild($wrapper);
            //}
            //$this->node->appendChild($slotDefault);
        }
        
        $append = new PhpNode('foreach', '$this->slots("'.$this->attrs['name'].'") as $slot');
        // todo: solve this hack
        $r = '($slot)('.$dataString.')';
        $append->appendChild(new DomNode('#php', '<?php ' . $r . '; ?>'));
        $this->node->appendChild($append);
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
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['name'] = 'default';
        
        // mime like we have a simple node as component slot containing a slot node too
        $wrapper = new DomNode('#slot');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());

        //$data = $this->depleteNode($this->node);
        //$data = $this->fillNode(null, $data);
        //$dataString = Helper::arrayToEval($data);
        //$wrapper->setAttribute('slot', $this->attrs['slot']);
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');

        $this->parser->parseNode($wrapper, $this->config, $this->context);
return;
        $this->node->changeNode('#slot');
        if ($this->hasSlotDefault) {
            $if = sprintf('empty($this->slots("%s"))', $this->attrs['name']);
            $this->node->setAttribute('p-if', $if);
            //$slotDefault = new PhpNode('if', $if);
            //$this->node->parentNode->insertBefore($slotDefault, $this->node);
            //$slotDefault->appendChild($this->node->detach());
            
            $this->parser->parseNode($this->node, $this->config, $this);
            
            foreach ($this->node->childNodes as $cn) {
                $this->parser->parseNode($cn, $this->config, $this);
            }
            
            $node = new DomNode('#root');
            foreach ($this->node->childNodes as $cn) {
                $node->appendChild($cn->detach());
                
                $this->parser->parseNode($cn, $this->config, $this);
                //(new Root($this->process, $node, $name, $this->context))->rootContext();
                
                $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", $this->template("%s", %s)); ?>', 
                    $this->id, $this->context->getId(), $this->attrs['slot'], $name, '[]'
                );
                $cn->changeNode('#php', $r);
                $cn->empty();
                $slotDefault->appendChild($cn->detach());
            }
            $this->node->appendChild($slotDefault);
        }
        
        $append = new PhpNode('foreach', '$this->slots("'.$this->attrs['name'].'") as $_slot');
        $r = sprintf('<?php $this->comp[%d]->addSlot("%s", $_slot); ?>',
            $this->context->getId(), $this->attrs['slot']
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