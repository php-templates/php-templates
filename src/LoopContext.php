<?php

namespace PhpTemplates;

/**
 * Works same as context class, but it scope inside only given variables. 
 * i = 0; foreach (x as y => z) { i++ } -> i will be from outside, modifiable, while only y and z will be scoped
 */
class LoopContext implements ContextInterface
{
    public $parent;
    private $data;

    public function __construct(array $data, $parent)
    {
        $this->data = $data;
        $this->parent = $parent;
    }

    public function &__get($prop)
    {
        return $this->get($prop);
    }

    public function __set($prop, $val)
    {
        if (array_key_exists($prop, $this->data)) {
            $this->data[$prop] = $val;
        }
        else {
            $this->parent->$prop = $val;
        }

        return $val;
    }

    public function __isset($prop)
    {
        return !is_null($this->get($prop));
    }

    public function merge(array $data)
    {
        $this->data = array_intersect_key($this-data, $data);
        $this->parent->merge($data);
        
        return $this;
    }

    public function subcontext(array $data = [])
    {
        return new Context($data, $this);
    }

    public function has(string $prop)
    {dd(__FILE__);
        return array_key_exists($prop, $this->data);
    }

    public function &get($prop, $safe = true)
    {
        if (array_key_exists($prop, $this->data)) {
            return $this->data[$prop];
        }
        
        return $this->parent->get($prop);
    }

    public function all()
    {
        return $this->parent->all();
    }
    
    public function except(array $except)
    {
        return array_diff_key($this->parent->all(), array_flip($except));
    }
    
    public function root() 
    {
        $c = $this;
        while ($c->parent) {
            $c = $c->parent;
        }
        return $c;
    }
    
    public function __debugInfo() 
    {
        return $this->data;
    }
    
    public function clone() {dd(__FILE__);
        return new Context($this->data);
    }
}