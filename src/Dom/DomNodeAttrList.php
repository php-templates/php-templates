<?php

namespace PhpTemplates\Dom;

class DomNodeAttrList implements \IteratorAggregate, \Countable
{
    private $nodes;
    
    public function __construct($nodes)
    {
        $this->nodes = $nodes;
    }
    
    public function count(): int
    {
        return count($this->nodes);
    }
    
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->nodes);
    }
    
    public function item($i)
    {
        if (isset($this->nodes[$i])) {
            return $this->nodes[$i];
        }
        return null;
    }
    
    public function __get($prop)
    {
        if ($prop == 'length') {
            return count($this->nodes);
        }
        return $this->{$prop};
    }
}