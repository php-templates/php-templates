<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Process;

class Slot extends AbstractEntity
{
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public function __construct(Process $process, $node, AbstractEntity $context)
    {
        parent::__construct($process, $node, $context);

        $this->hasSlotDefault = $this->node->childNodes->length > 0;
    }

    public function simpleNodeContext()
    {
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
    
            $definition = 'foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$_slot->render(array_merge($this->scopeData, %s));'
            .PHP_EOL.'}';
    
            $this->println(
                sprintf($definition, $this->attrs['name'], $dataString)
            );
    
            if ($this->hasSlotDefault) {
                $this->println(sprintf('if (empty($this->slots("%s"))) {', $this->attrs['name']));
                foreach ($this->childNodes($this->node) as $slotDefault) {
                    $this->parseNode($slotDefault);
                }
                $this->println('}');
            }
        });

        $this->removeNode($this->node);
    }

    public function slotContext()
    {
        // throw new InvalidNodeException('Invalid slot location (slot in slot not allowed)', $this->node->parentNode);
    }

    /**
     * <myComp><slot name="mytitle" slot="title"></slot></myComp>
     *
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['name'] = 'default';

        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
    
            $definition = 'foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$this->comp[%d]->addSlot("%s", $_slot);'
            .PHP_EOL.'}';
            $this->println(
                sprintf($definition,
                $this->attrs['name'], 
                $this->context->depth, 
                $this->attrs['slot'], 
                //$dataString,
                //$this->name
                )
            );
            
            if ($childNodes = $this->childNodes()) {
                $this->println(
                    sprintf('if (empty($this->slots("%s"))) { ;', 
                    $this->attrs['name'])
                );
                foreach ($childNodes as $cn) {
                    $name = $this->attrs['name'] .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
                    $node = new HTML5DOMDocument;
dd(8);
                    $node->appendChild($node->importNode($cn, true));
                    (new TemplateFunction($this->process, $node, $name))->parse();
            
                    $this->println(
                        sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s));', 
                        $this->depth, $this->context->depth, $this->attrs['slot'], $name, '[]')
                    );
                }
                $this->println('}');
            }
        });
    }
}