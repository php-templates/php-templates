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
        if ($fn == 'Context') $fn = 'Template'; //todo other way
        $fn = lcfirst($fn).'Context';
        if ($node->nodeName === 'slot') {
            (new Slot($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->document, $node, $this))->{$fn}();
        }
        elseif ($this->isComponent($node)) {
            (new Component($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'template') {
            (new Template($this->document, $node, $this))->{$fn}();
        }
        else {
            (new SimpleNode($this->document, $node, $this))->{$fn}();
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
        
        // merged with default aliased
        $aliased = $this->document->config['aliased'];
        if (isset($aliased[$node->nodeName])) {
            return $aliased[$node->nodeName];
        }

        return null;
    }
}