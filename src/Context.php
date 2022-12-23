<?php

namespace PhpTemplates;

class Context
{
    public $parent;
    public $loopContext;
    private $loopDepth = 0;
    private $data;
    
    /**
     * This member propose is to handle cases like $foo.undefined.baz = x, bcz seting a null data on GET would affect $attrs bind() (involving objects would fail IF statements)
     */
    private $newvar = [
        'name' => null, // $varname
        'value' => null // $varvalue
    ];

    public function __construct(array $data = [], self $parent = null)
    {
        $this->data = $data ?? [];
        $this->parent = $parent;
    }

    public function &__get($prop)
    {
        if ($this->loopContext) {// legacy if
            return $this->loopContext->get($prop);
        }

        return $this->get($prop);
    }

    public function __set($prop, $val)
    {
        // @deprecated if
        if ($this->loopContext) {
            $this->loopContext->$prop = $val;
        } else {
            $this->data[$prop] = $val;
        }
        
        return $val;
    }

    public function __isset($prop)
    {
        return !is_null($this->get($prop));
    }

    public function merge(array $data)
    {
        //array_unshift($data, $this->data);
        //$this->data = call_user_func_array('array_merge', $data);
        $this->data = array_merge($this->data, $data);
        
        return $this;
    }

    public function leaseMerge(array $data)
    {// legacy
        $this->data = array_merge($data, $this->data);
    }

    public function subcontext(array $data = [])
    {
        if ($this->loopContext) {
            return new Context($data, $this->loopContext);
        }

        return new Context($data, $this);
    }
//@deprecated
    public function loopStart()
    {
        if ($this->loopDepth <= 0) {
            $this->loopContext = $this->subcontext();
        }
        $this->loopDepth++;
    }
//@deprecated
    public function loopEnd()
    {
        $this->loopDepth--;
        if ($this->loopDepth <= 0) {
            $this->loopContext = null;
        }
    }

    public function has(string $prop)
    {
        $this->sync();
        return array_key_exists($prop, $this->data);
    }

    public function &get($prop, $safe = true)
    {
        $this->sync();
        if ($prop == '_context') {
            return $this;
        }
        if ($prop == '_data') {
            return $this->data;
        }

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
    
    public function share($data) 
    {
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
