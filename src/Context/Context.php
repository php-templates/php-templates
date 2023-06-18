<?php

namespace PhpTemplates\Context;

use PhpTemplates\Contracts\Context as ContextInterface;

/**
 * Context is the way I trait variables inside a scope (slot, component, etc) in order to better control them
 */
class Context implements ContextInterface
{
    public $parent;
    private $data;
    
    /**
     * This member propose is to handle cases like $foo.undefined.baz = x, bcz seting a null data on GET 
     * would affect $attrs bind() (involving objects would fail IF statements)
     */
    private $newvar = [
        'name' => null, // $varname
        'value' => null // $varvalue
    ];

    public function __construct(array $data = [], $parent = null)
    {
        $this->data = $data ?? [];
        $this->parent = $parent;
    }

    public function &__get($prop)
    {
        return $this->get($prop);
    }

    public function __set($prop, $val)
    {
        $this->data[$prop] = $val;

        return $val;
    }

    public function __isset($prop)
    {
        return !is_null($this->get($prop));
    }

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
        $this->sync();
        return array_key_exists($prop, $this->data);
    }

    public function &get($prop, $safe = true)
    {
        $this->sync();

        if (array_key_exists($prop, $this->data)) {
            return $this->data[$prop];
        } 
        elseif ($this->parent) {
            return $this->parent->get($prop);
        }
        
        $this->newvar['name'] = $prop;
        $this->newvar['value'] = null;
        
        return $this->newvar['value'];
    }

    public function all()
    {
        $this->sync();
        return $this->data;
    }
    
    public function except(array $except)
    {
        $this->sync();
        return array_diff_key($this->data, array_flip($except));
    }
    
    public function root() 
    {
        $c = $this;
        while ($c->parent) {
            $c = $c->parent;
        }
        return $c;
    }
    
    private function sync() {
        if (!array_key_exists($this->newvar['name'], $this->data) && !is_null($this->newvar['value'])) {
            $this->data[$this->newvar['name']] = $this->newvar['value'];
        }
        $this->newvar['name'] = $this->newvar['value'] = null;
    }
    
    public function __debugInfo() 
    {
        $this->sync();
        return $this->data;
    }
    
    public function clone() {
        return new Context($this->data);
    }
    
    /**
     * legacy
     * Generates a new context where root context shares additional data only for this subcontext tree
     * root would be a clone of original root
     * Used for fancy operations
     */
    public function share($data) 
    {dd('legacy');
        if (!$data || !is_array($data)) {
            return $this;
        }
        
        if (!$this->parent) {
            $this->merge($data);
            return $this;
        }
        
        $newRoot = $this->root()->clone();
        $this->parent = $newRoot->share($data);

        return $this;
    }
}
