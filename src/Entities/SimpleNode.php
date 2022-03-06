<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;
use IvoPetkov\HTML5DOMDocument;

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

        $node = @$this->node->cloneNode(true);
        if ($node && method_exists($this->caret->parentNode, 'insertBefore')) {
            $this->removeNode($this->node);
            $this->node = $node;
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
        }


        $this->depleteNode($this->node, function($data, $c_structs) use ($node) {
            if ($node/* || $this->caret->parentNode->ownerDocument*/) {
                    //$this->caret->parentNode->inseerBefore($this->node, $this->caret);
                $c_structs && $this->phpClose();
                $this->caret->parentNode->insertBefore($this->node, $this->caret);
                
            }
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            if ($node && $c_structs) {
                $this->phpOpen();         
            }
//$data['x'] = 123;
            $this->fillNode($this->node, $data);
            if ($node) {// if ($this->node->nodeName === 'option') dd(44);

            }
        });
        
        $this->shouldClosePhp && $this->phpClose();
    }

    public function componentContext()
    {
        if ($this->node->nodeValue == 'foo') {
            //$this->println('line');
            //dom($this->caret->parentNode);d('....');
        }
        //dom($this->node);
//setattr de proba
        $this->attrs['slot'] = 'default';
        $this->attrs['_index'] = 0;
        //if ($this->node->parentNode) {
        //nu merge... nu se face register ce naiba...
        //pt ca comp register e chemat cred inainte de asta si ii zboara nodurile inainte sa faca si el register
        //cam asta se intampla? nu cred, pt ca register comp se face pe definitie comp
        $this->depleteNode($this->node, function($data) {
            $this->fillNode($this->node, $data);
            //$this->fillNode($this->node, ['x'=>13]);
            //$dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
            $node = new HTML5DOMDocument;
  
            $node->appendChild($node->importNode($this->node, true));
            (new Template($this->document, $node, $name))->newContext();
    
            $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));
            //dd($dataString);
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots));', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString)
            );
        });
if ($this->node->nodeValue == 'foo') {
    //dom($this->caret->parentNode);
    //dd(444);
}
        //dom($this->node);die();
    }
    
    public function blockContext()
    {
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);
            $dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.Helper::uniqid();
            $node = new HTML5DOMDocument;
            $node->appendChild($node->importNode($this->node, true));
            (new Template($this->document, $node, $name))->newContext();
    
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
            $this->phpClose();
            if ($this->node->nodeName === 'select') {
                //dd($data);
            }
            
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
            $this->phpOpen();
        });
        //if ($this->shouldClosePhp) {
            //$this->phpClose();
        //}
    }
}