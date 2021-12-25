<?php

namespace DomDocument\PhpTemplates;

class Parsed
{
    public static $templates = [];

    protected $type;
    protected $parent = null;
    protected $name;
    protected $data;
    protected $slots;
    protected $func;
    protected $rendered = false;
    
    public static function template($name, $data = [])
    {
        return new self('template', $name, $data);
    }
    
    public function __construct($type, $name, $data = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->data = $data;
        //d('init '.$this->name, $data);
        
        $this->func = \Closure::bind(self::$templates[$this->name], $this);
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
        //d($this->name, $this->parent->name, 1);
    }
    
    public function render($parentScope = [])
    {
        $this->data['_attrs'] = array_keys($this->data);//d($this->data);
        $this->data['_name'] = $this->name;
        $data = array_merge($parentScope, $this->data);
        if (!$this->rendered) {
            $this->rendered = true; // stop infinite loop
            $continue = DomEvent::event('rendering', $this->name, $this, $data);
            if (!$continue) {
                return;
            }
        }
        
        if ($this->type === 'template') {
            //$func = self::$templates[$this->name];
        } elseif ($this->type === 'layout') {
            //$func = self::$layouts[$this->name];
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
        //dd($op->name);
        return $op;
    }
}