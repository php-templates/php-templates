<?php

namespace PhpTemplates\Traits;

use PhpTemplates\Entities\Block;
use PhpTemplates\Entities\Component;
use PhpTemplates\Entities\SimpleNode;
use PhpTemplates\Entities\Slot;
use PhpTemplates\Entities\Template;

trait CanParseNodes {
    protected function parseNode($node)
    {
        $fn = explode('\\', get_class($this));
        $fn = end($fn);

        $fn = lcfirst($fn).'Context';
        if ($node->nodeName === 'slot') {
            (new Slot($this->process, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->process, $node, $this))->{$fn}();
        }
        elseif ($this->isComponent($node)) {
            (new Component($this->process, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'template') {
            (new Template($this->process, $node, $this))->{$fn}();
        }
        else {
            (new SimpleNode($this->process, $node, $this))->{$fn}();
        }
    }
    
    protected function isComponent($node)
    {
        if (!@$node->nodeName) {
            return null;
        }
        if ($node->nodeName === 'template') {
            return $node->getAttribute('is');
        }
        
        return $this->process->getAliased($node->nodeName);
    }
}