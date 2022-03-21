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
     * gained at render time, make an array_diff_keys between them and passed attributes to obdain the p-bind="$this->attrs" variables
     * @var array
     */
    public $attrs = [];

    /**
     * render function to be called
     * @var Closure
     */
    protected $func;

    /**
     * if the render function has been triggered
     *
     * @var boolean
     */
    protected $rendered = false;
    
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
        $this->attrs['_index'] = $i;
        return $this;
    }
    
    public function render($parentScope = [])
    {
        $this->scopeData = array_merge($parentScope, $this->data);
        $this->scopeData['_name'] = $this->name;
         
        $name = trim($this->name, './\\');
        if (!isset($this->scopeData['_cpath'])) {
            $this->scopeData['_cpath'] = $event = $name;
        } else {
            $event = explode('.', $this->scopeData['_cpath'])[0].'.'.$name;
            $this->scopeData['_cpath'] .= '.'.$name;
            $event = $this->scopeData['_cpath'];
        }

        if (!$this->rendered) {
            $this->rendered = true; // stop infinite loop
            $continue = DomEvent::event('rendering', $event, $this, $this->scopeData);
            if (!$continue) {
                return;
            }
        }
        $func = $this->func;
        $func($this->scopeData, $this->slots);
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
    
    public function withName($name)
    {
        $this->name = $name;
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