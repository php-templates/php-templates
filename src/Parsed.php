<?php

namespace PhpTemplates;

class Parsed
{
    public static $templates = [];
    public static $templateBlocks = [];

    protected $parent = null;
    protected $name;
    public $data;
    public $block = [];
    public $slots;
    protected $func;
    protected $rendered = false;
    
    public $comp = []; // for avoiding polluting scope
    
    public static function template($name, $data = [])
    {
        return new self($name, self::$templates[$name], $data);
    }
    
    public static function raw($name, \Closure $fn, $data = [])
    {
        if (!$name) {
            $name = uniqid();
        }
        return new self($name, $fn, $data);
    }
    
    private function __construct($name, \Closure $fn, $data = [])
    {
        $this->name = $name;
        $this->data = $data;
        
        $this->func = \Closure::bind($fn, $this);
    }
    
    public function addSlot($pos, self $renderable)
    {
        $this->slots[$pos][] = $renderable;
        $renderable->setParent($this);
        return $renderable;
    }
    
    public function setSlots($slots)
    {
        $this->slots = $slots;
        return $this;
    }
    
    public function setParent(self $parent)
    {
        if (!$this->parent) {
            $this->parent = $parent;
        }
    }

    public function setIndex($i)
    {
        $this->data['_index'] = $i;
        return $this;
    }
    
    public function render($parentScope = [])
    {
        //if ($this->name === 'a2') dd($this->slots['a2']);
        $this->data['_attrs'] = array_keys($this->data);//d($this->data);
        $this->data['_name'] = $this->name;
        $data = array_merge($parentScope, $this->data);
        
        $name = trim($this->name, './\\');
        if (!isset($data['_cpath'])) {
            $data['_cpath'] = $event = $name;
        } else {
            $event = explode('.', $data['_cpath'])[0].'.'.$name;
            $data['_cpath'] .= '.'.$name;
            $event = $data['_cpath'];
        }
        //d('evvvvv',$event);
        if (!$this->rendered) {
            $this->rendered = true; // stop infinite loop
            $continue = DomEvent::event('rendering', $event, $this, $data);
            if (!$continue) {
                return;
            }
        }
        $func = $this->func;
        $func($data, $this->slots);
    }
    
    public function __get($prop)
    {
        return $this->$prop;
    }
    
    public function originParent()
    {
        $op = $this->parent;
        while ($op->parent) {
            $op = $op->parent;
        }

        return $op;
    }
}