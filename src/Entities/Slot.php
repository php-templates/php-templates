<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\InvalidNodeException;

class Slot extends AbstractEntity
{
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public function __construct(Document $doc, $node, AbstractEntity $context)
    {
        parent::__construct($doc, $node, $context);

        $this->hasSlotDefault = $this->node->childNodes->length > 0;
    }

    public function simpleNodeContext()
    {
        if ($shouldClosePhp = !$this->phpIsOpen()) {
            $this->phpOpen();
        }
        $data = $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
    
            $definition = 'foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$_slot->render(array_merge($this->data, %s));'
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
        if ($shouldClosePhp) {//d($this->attrs, 'todo');
            //$this->println('?');
            $this->phpClose();
            //nu merg if uri ratacite intre tag uri fiecare trbinchissi deschis pe iter
        }

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
if ($this->node->getAttribute('name') == 'sn9') {
   // dom($this->caret->parentNode);
    //d(55555);
}
        $this->phpOpen('');
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
                   // $node->preserveWhiteSpace = false;
                 //   $node->formatOutput = true;
                    $node->appendChild($node->importNode($cn, true));
                    (new Template($this->document, $node, $name))->newContext();
            
                    $this->println(
                        sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s));', 
                        $this->depth, $this->context->depth, $this->attrs['slot'], $name, '[]')
                    );
                }
                $this->println('}');
            }
        });
if ($this->attrs['name'] == 'sn9') {
   // dom($this->caret->parentNode);
   // dd(7777);
}
    }
}