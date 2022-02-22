<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class SimpleNode extends AbstractEntity
{
    protected $attrs = [];

    public function simpleNodeContext()
    {
        $this->templateContext();
    }
    
    public function templateContext()
    {
        if (!$this->node->parentNode) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            return;
        }

        $node = null;
        if (method_exists($this->caret->parentNode, 'inseerBefore')) {
            $node = $this->node->cloneNode(true);
            $this->removeNode($this->node);
            $this->node = $node;
            $this->caret->parentNode->inseerBefore($this->node, $this->caret);
        }

        $this->depleteNode($this->node, function($data, $c_structs) use ($node) {
            if ($node/* || $this->caret->parentNode->ownerDocument*/) {
                    $this->caret->parentNode->inseerBefore($this->node, $this->caret);
                
            } else {
                //d(1);
            }
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            $c_structs && $this->println('?>');
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
            $c_structs && $this->println('<?php ;');
        });
        
        $this->shouldClosePhp && $this->phpClose();
    }

    public function componentContext()
    {
        //dom($this->node);

        $this->attrs['slot'] = 'default';
        //if ($this->node->parentNode) {
        //nu merge... nu se face register ce naiba...
        //pt ca comp register e chemat cred inainte de asta si ii zboara nodurile inainte sa faca si el register
        //cam asta se intampla? nu cred, pt ca register comp se face pe definitie comp
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
            (new Template($this->document, $this->node, $name))->newContext();
    
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s));', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString)
            );
        });
        //dom($this->node);die();
    }
    
    public function blockContext()
    {
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.Helper::uniqid();
            (new Template($this->document, $this->node, $name))->newContext();
    
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots));', 
                $this->depth, $this->context->depth, $this->context->name, $name, $dataString)
            );
        });
    }

    /**
     * as slot default
     */
    public function slotContext()
    {
        $this->node = $this->node->cloneNode(true);
        // close php
        $this->depleteNode($this->node, function($data) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            $this->phpClose();
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
            $this->phpOpen();
        });
    }
}