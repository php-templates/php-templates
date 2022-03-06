<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;
use IvoPetkov\HTML5DOMDocument;

class AnonymousComponent extends AbstractEntity
{
    protected $attrs = [];

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['_index'] = 0;
        
        $this->depleteNode($this->node, function($data) {
            $this->fillNode($this->node, $data);
            //$this->fillNode($this->node, ['x'=>13]);
            //$dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
            $node = new HTML5DOMDocument;
            foreach ($this->node->childNodes as $cn) {
                $node->appendChild($node->importNode($cn, true));
            }
            (new Template($this->document, $node, $name))->newContext();
            $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));
            //dd($dataString);
            $this->println(
                sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots));', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString)
            );
        });
    }
}

