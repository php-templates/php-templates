<?php

namespace DomDocument\PhpTemplates;

class Parsed
{
    public static $templates = [];
    public static $layouts = [];

    protected $type;
    protected $name;
    protected $data;
    protected $slots;
    protected $rendered = false;
    
    public static function template($name, $data = [])
    {
        return new self('template', $name, $data);
    }
    
    public static function layout($name, $data = [])
    {
        return new self('layout', $name, $data);
    }
    
    public function __construct($type, $name, $data = [])
    {
        if ($type === 'layouts') {
            $name .= 'layout:'.$name; // to avoid event conflicts
        }
        $this->type = $type;
        $this->name = $name;
        $this->data = $data;
    }
    
    public function addSlot($pos, self $renderable)
    {
        $this->slots[$pos][] = $renderable;
        return $renderable;
    }
    
    public function render($parentScope = [])
    {
        $this->data['_attrs'] = array_keys($this->data);
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
            $func = self::$templates[$this->name];
        } elseif ($this->type === 'layout') {
            $func = self::$layouts[$this->name];
        }
        
        $func($data, $this->slots);
    }
}