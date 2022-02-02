<?php

namespace PhpTemplates;

class NodeParser
{
    public static function parse($node, $context)
    {
        $return = true;
        $fn = get_class($context);
        $fn = lcfirst($fn).'Context';
        if ($node->nodeName === 'slot') {
            (new Slot($this->document, $node, $context))->mount($refNode);
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->document, $this->name))->mount($refNode);
        }
        elseif (Helper::isComponent($node)) {
            (new Component($this->document, $node, $context))->{$fn}();
        }
        elseif ($node->nodeName === 'template') {
            (new AnonymousComponent($this->document))->mount($refNode);
        }
        else {
            (new SimpleNode($this->document, $node))->mount($refNode);
            $return = false;
        }
    }
}