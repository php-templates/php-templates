<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class Component extends AbstractEntity
{
    protected $attrs = ['is' => null];

    public function __construct(Document $doc, $node, AbstractEntity $context)
    {
        parent::__construct($doc, $node, $context);

        $this->name = Helper::isComponent($this->node);
    }
    
    public function simpleNodeContext()
    {
        $this->templateContext();
    }
    
    public function templateContext()
    {
        $this->phpOpen();
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);

            $dataString = Helper::arrayToEval($data);
            (new Template($this->document, $this->name))->newContext();
    
            $this->println(
                sprintf('$this->comp[%d] = Parsed::template("%s", %s);', $this->depth, $this->name, $dataString)
            );       
            foreach ($this->childNodes() as $slot) {
                $this->parseNode($slot);
            }
            //d($this->caret);
            $this->println(
                sprintf('$this->comp[%d]->render($this->data);', $this->depth)
            );
        });
        if ($this->shouldClosePhp) {
            $this->phpClose();
        }
        $p = $this->node->parentNode;
//dom($p);d('--->');
        $this->removeNode($this->node);
        //dd($x);
        //dom($x); die();
//dom($p);
    }

    /**
     * When a component is passed as slot to another component
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->depleteNode($this->node, function($data) {
            $data = $this->fillNode(null, $data);   
            $dataString = Helper::arrayToEval($data);
            (new Template($this->document, $this->name))->newContext();
    
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s));', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $this->name, $dataString)
            );
            
            foreach ($this->childNodes() as $slot)
            {
                $this->parseNode($slot);
            }
        });
    }

    /**
     * When component is passed as block default
     */
    public function blockContext()
    {
        $this->node->setAttribute('slot', $this->context->name);
        $this->componentContext();
    }

    /**
     * When a component is passed as slot default
     */
    public function slotContext()
    {
//dd('component.slotcontext');
//nu e comp context, e template context cu if
//cel mai probabil trb sa fac set slot de sus in jos
//div class="x"> se rupe aic
        $this->templateContext();
        //if ($this->shouldClosePhp)
    }
}