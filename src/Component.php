<?php

namespace DomDocument\PhpTemplates;

class Component
{
    public static $templates = [];

    protected $func;
    protected $data;
    protected $slots;
    
    public function __construct($func, $data = [])
    {
        //$this->uid = (self::$index++);
        $this->func = $func;
        $this->data = $data;
    }
    
    public function getId()
    {
        return $this->uid;
    }
    
    public function addSlot($pos, $renderable)
    {
        $this->slots[$pos][] = $renderable;
        return $renderable;
    }
    
    public function render($parentScope)
    {//d($this->slots);
        $func = self::$templates[$this->func];//d(1122, $this->data);
        $this->data['_attrs'] = array_keys($this->data);
        $func(array_merge($parentScope, $this->data), $this->slots);
    }
}