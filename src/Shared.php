<?php

namespace PhpTemplates;

class Shared implements ContextInterface
{
    private $data = [];
    
    public function merge(array $data)
    {
        $this->data = array_merge($this->data, $data);
        
        return $this;
    }
    
    public function subcontext(array $data = [])
    {
        return new Context($data, $this);
    }
    
    public function has(string $prop)
    {
        return array_key_exists($prop, $this->data);
    }
    
    public function &get($prop, $safe = true) 
    {
        if (!array_key_exists($prop, $this->data)) {
            $x = null;
            return $x;
        }
        
        $val = $this->data[$prop];
        if ($val instanceof \Closure) {
            $this->data[$prop] = $val();
        }
        
        return $this->data[$prop];
    }
    
    public function __isset($prop)
    {
        return !is_null($this->get($prop));
    }
    
    public function __get($prop)
    {
        return $this->get($prop);
    }
}