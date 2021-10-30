<?php

namespace DomDocument\PhpTemplates;

class Component
{
    protected $func;
    protected $data;
    protected $slots;
    
    public function __construct($func, $data)
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
    }
    
    public function render()
    {
        $func = $this->func;//d(1122, $this->data);
        $func($this->data, $this->slots);
    }
}