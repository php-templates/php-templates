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
        /*
        $this->caret = $this->node;
        
        if ($this->shouldClosePhp) {
            $this->println('?>');
        }
        // don t close if received opened php
        //$shouldClosePhp = ;
        //ramane php deschid de la elseif, ca ala de jos nu il inchide... si asta mai jos face echo open php pt ca e deschis...
        $this->depleteNode($this->node, function($data, $node) use (&$phpOpen) {
            $this->fillNode($this->node, $data);   
            if ($phpOpen = $this->phpIsOpen()) {
                
            }
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
        });
        if ($this->phpIsOpen()) {d(1);
            $this->println('?>');
            $this->println('<?php -;', 'after');
        }
        d('x', $this->node->nodeName.'.'.$this->node->nodeValue);
        if ($this->shouldClosePhp) {d(11);
            //$this->phpClose('');
            //nu se inchide...
        } else {d(0);}
       // d($this->node->nodeName);
       */
       //d($this->node);
       $node = $this->node;
       $this->document->toberemoved[] = $node;
        $this->node = $this->node->cloneNode(true) ? $this->node->cloneNode(true) : $this->node;
    //d(1, $this->node);
        // close php
        
        $this->depleteNode($this->node, function($data, $c_structs) {
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            //$this->phpClose();
            //nu am caret
            //if (!$this->caret->parentNode) dd($this->caret);
            $opened = $this->phpIsOpen();
            
            /*if ($opened) {
                $this->println('?>');
                $this->phpClose('');
            }*/
            $c_structs && $this->phpClose();
            $this->caret->parentNode->insertBefore($this->node, $this->caret);
            $c_structs && $this->phpOpen();
            /*if ($opened) {
                $this->println('<?php ;');
                $this->phpOpen('');
            }*/
        });
        
        $this->shouldClosePhp && $this->phpClose();
    }

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        
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
    
    private function enclosePhp()
    {
        $this->node->parentNode->insertBefore(
            $this->node->ownerDocument->createTextNode('?>'),
            $this->node
        );
        if ($this->node->nextSibling) {
            $this->node->parentNode->insertBefore(
                $this->node->ownerDocument->createTextNode('<?php ;'),
                $this->node->nextSibling
            );
        } else {
            $this->node->parentNode->appendChild($this->node->ownerDocument->createTextNode('<?php ;'));
        }
    }
}