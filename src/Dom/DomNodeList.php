<?php

namespace PhpTemplates\Dom;

class DomNodeList implements \IteratorAggregate, \Countable
{
    private $nodes;
    
    public function __construct($nodes)
    {
        $this->nodes = $nodes;
    }
    
    public function count()
    {
        return count($this->nodes);
    }
    
    public function getIterator()
    {
        return new \ArrayIterator(array_map(function($n) {
            return new DomNode($n);
        }, iterator_to_array($this->nodes)));
    }
}