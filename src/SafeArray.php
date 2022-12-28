<?php

namespace PhpTemplates;

// todo: remove this class added to support syntaxes like context[undefined][undefined] = x; but I have to abort bcz this is a get, and i have to return false value in case of undefined 
class SafeArray extends \ArrayObject implements \Stringable
{
    private $parent;
    private $key;
    
    public function __construct(\ArrayAccess $parent, string $key, &$var) 
    {
        $this->parent = $parent;
        $this->key = $key;
        $this['value'] = &$val;
    }
    
    public function offsetSet($offset, $value) {
        parent::offsetSet($offset, $value);
        $this->parent[$this->key] = $this['value'];
    }
/*
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset) {
        if (!isset($this->data[$offset])) {
            return new self($this, $offset);
        }
        
        return $this->data[$offset];
    }
    
    public function getIterator(): \Traversable 
    {
        return new \ArrayIterator($this->data);
    }*/
    
    public function __toString() 
    {
        return (string)$this['value'];
    }
    
    public function __debugInfo() 
    {
        return $this['value'];
    }
}