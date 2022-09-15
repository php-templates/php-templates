<?php

namespace PhpTemplates;

class Context
{
    //private static $baseid = 1;
    
    //private $id;
    public $parent;
    public $loopContext;
    private $loopDepth = 0;
    private $data;// scope getable as obj
    
    public function __construct(array $data = [], self $parent = null) 
    {
        $this->data = $data ?? [];
        $this->parent = $parent;
        
        //$this->id = self::$baseid;
        //self::$baseid++;
    }
    
    public function &__get($prop) 
    {
        if ($this->loopContext) {
            return $this->loopContext->get($prop);
        }
        
        return $this->get($prop);
    }
    
    public function __set($prop, $val) 
    {
        if ($this->loopContext) {
            $this->loopContext->$prop = $val;
        }
        else {
            $this->data[$prop] = $val;
        }
        //d($this->id.'set'.$prop.'='.$val);
        //$prop == 'slot' && !$val && dd(3);
        //$prop == 'slot' && d($val);
        //d($this->data);
    }
    
    public function __isset($prop) 
    {
        return !is_null($this->get($prop));
    }
    
    public function merge(array ...$data) 
    {
        array_unshift($data, $this->data);
        $this->data = call_user_func_array('array_merge', $data);//array_merge($this->data, $data);
    }
    
    public function subcontext(array $data = []) 
    {
        //empty($data['name']) && !d($this->parent) && debug_print_backtrace(2);
        return new Context($data, $this);
    }
    
    public function loopStart()
    {
        if ($this->loopDepth <= 0) {
            $this->loopContext = $this->subcontext();
        }
        $this->loopDepth++;
    }
    
    public function loopEnd() 
    {
        $this->loopDepth--;
        if ($this->loopDepth <= 0) {
            $this->loopContext = null;
        }
    }
    
    public function has(string $prop) {
        return array_key_exists($prop, $this->data);
    }
    
    public function &get($prop) 
    {
        if (array_key_exists($prop, $this->data)) {
            return $this->data[$prop];
        }
        elseif (isset($this->data['_attrs']) && array_key_exists($prop, $this->data['_attrs'])) {
            return $this->data['_attrs'][$prop];
        }
        elseif ($this->parent) {
            return $this->parent->get($prop);
        }
        
        $this->data[$prop] = null;
        if ($prop == '_attrs') {
            $this->data['_attrs'] = [];
        }
        
        return $this->data[$prop];
    }
    
    public function all() {
        return $this->data;
    }
}