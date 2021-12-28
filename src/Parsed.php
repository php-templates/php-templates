<?php

namespace DomDocument\PhpTemplates;

class Parsed
{
    public static $templates = [];

    protected $parent = null;
    protected $name;
    protected $data;
    protected $slots;
    protected $func;
    protected $rendered = false;
    
    public static function template($name, $data = [])
    {
        return new self($name, $data);
    }
    
    public function __construct($name, $data = [])
    {
        $this->name = $name;
        $this->data = $data;
        
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
    }

    public function setIndex($i)
    {
        $this->data['_index'] = $i;
        return $this;
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