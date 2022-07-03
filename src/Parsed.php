<?php

namespace PhpTemplates;

use Closure;

class Parsed
{
    /**
     * Array of templateFunctions keyed by relative template file path
     *
     * @var array
     */
    public static $templates = [];

    /**
     * Parent / context
     * @var self
     */
    protected $parent = null;

    /**
     * called template function name
     * @var string
     */
    protected $name;

    /**
     * Filled at render time, keeped here to allow further modifications on events callbacks
     *
     * @var array
     */
    public $scopeData = [];

    /**
     * Data passed to component using node attributes
     *
     * @var array
     */
    public $data = [];

    /**
     * render function to be called
     * @var Closure
     */
    protected $func;
    
    /**
     * Array of Parsed entities keyed by slot position
     * @var array
     */
    public $slots = [];

    /**
     * recyclable for avoiding polluting function variables scope
     * @var array numeric indexes representing depth level
     */
    public $comp = [];

    /**
     * recyclable for avoiding polluting function variables scope
     * @var array numeric indexes representing depth level
     */
    public $block = [];
    
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
    
    private function __construct($name, \Closure $fn, $attrs = [])
    {
        $this->name = $name;
        $this->data = $attrs;
        
        $this->func = \Closure::bind($fn, $this);
    }
    
    public function slots($pos)
    {
        if (isset($this->slots[$pos])) {
            return $this->slots[$pos];
        }
        return [];
    }
    
    public function addSlot($pos, self $renderable)
    {
        $this->slots[$pos][] = $renderable;

        return $renderable;
    }
    
    public function setSlots($slots)
    {
        $this->slots = $slots;

        return $this;
    }

    public function setIndex($i)
    {
        $this->attrs['_index'] = $i;

        return $this;
    }
    
    public function render($parentScope = [])
    {
        $this->scopeData = array_merge($parentScope, $this->data);
        $this->scopeData['_name'] = $this->name;

        $func = $this->func;
        $func(array_merge($this->scopeData, $this->data));
    }
    
    public function __get($prop)
    {
        if (isset($this->{$prop})) {
            return $this->{$prop};
        }
    }
    
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    public function withData(array $data)
    {
        $this->data = array_merge($data, $this->data);
        
        return $this;
    }
}

Parsed::$templates['***block'] = function($data) {
    extract($data);
    if (isset($this->slots[$this->name])) {
        usort($this->slots[$this->name], function($a, $b) {
            $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
            $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
            return $i1 - $i2;
        });
        foreach ($this->slots($this->name) as $_slot) {
            $_slot->render($this->scopeData);
        }
    }
};