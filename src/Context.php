<?php

namespace PhpTemplates;

class Context
{
    //private static $baseid = 1;
    
    //private $id;
    private $parent;
    private $loopContext;
    private $loopDepth = 0;
    private $data;
    
    public function __construct(array $data = [], self $parent = null) 
    {
        $this->data = $data ?? [];
        $this->parent = $parent;
        
        //$this->id = self::$baseid;
        //self::$baseid++;
    }
    
    public function &__get($prop) 
    {
        //d($this->id.'get'.$prop);
        //d($this);
        if (isset($this->loopContext->$prop)) {
            return $this->loopContext->$prop;
        }
        
        if (array_key_exists($prop, $this->data)) {
            return $this->data[$prop];
        }
        
        //d($this->data);
        if (!array_key_exists($prop, $this->data) && !isset($this->parent->$prop)) {
            $this->data[$prop] = null;
        }
        elseif (isset($this->parent->$prop)) {
            // import from parent
            $this->data[$prop] = $this->parent->prop;
        }
        //$prop == 'slot' && !$this->data[$prop] && dd($this->parent->$prop);
        return $this->data[$prop];
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
        return array_key_exists($prop, $this->data) || isset($this->parent->$prop);
    }
    
    public function merge(array $data = []) 
    {
        $this->data = array_merge($this->data, $data);
    }
    
    public function subcontext(array $data = []) 
    {
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
}