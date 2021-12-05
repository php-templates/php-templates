<?php

namespace DomDocument\PhpTemplates;

class Component
{
    public static $templates = [];

    protected $name;
    protected $data;
    protected $slots;
    protected $rendered = false;
    
    public function __construct($name, $data = [])
    {
        //$this->uid = (self::$index++);
        $this->name = $name;
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
    {
        if (!$this->rendered) {
            $this->rendered = true; // stop infinite loop
            $continue = DomEvent::event('rendering', $this->name, $this, $data);
            if (!$continue) {
                return;
            }
        }

        $func = self::$templates[$this->name];
        $this->data['_attrs'] = array_keys($this->data);
        $func(array_merge($parentScope, $this->data), $this->slots);
    }
}