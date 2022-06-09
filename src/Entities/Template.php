<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Helper;
use PhpTemplates\Dom\DomNode;

/**
 * is actually component, but used in different contexts, even on root
*/
class Template extends AbstractEntity
{
    protected $attrs = [];

    public function simpleNodeContext()
    {
        $this->isHtml = true;
        $this->depleteNode($this->node, function($data) {
            $this->node->changeNode('#template');
            foreach ($this->childNodes($this->node) as $slot) {
                $this->parseNode($slot);
            }
            $this->fillNode($this->node, $data);
            //$this->caret->parentNode->insertBefore($this->node->detach(), $this->caret);
        });

        //$this->removeNode($this->node);
    }

    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $this->attrs['_index'] = 0;

        $this->depleteNode($this->node, function($data) {
            $this->fillNode($this->node, $data);
            //$this->fillNode($this->node, ['x'=>13]);
            //$dataString = Helper::arrayToEval($data);
            $name = $this->context->name .'?slot='.$this->attrs['slot'].'&id='.Helper::uniqid();
            $node = new DomNode('#root');
            foreach ($this->node->childNodes as $cn) {
                $node->appendChild($cn->detach());
            }
            (new TemplateFunction($this->process, $node, $name))->parse();
            $dataString = Helper::arrayToEval($this->fillNode(null, $this->attrs));
            $r = sprintf('<?php $this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("%s", %s)->setSlots($this->slots)); ?>', 
                $this->depth, $this->context->depth, $this->attrs['slot'], $name, $dataString
            );
            $this->node->changeNode('#pho', $r);
        });
    }
}