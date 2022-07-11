<?php

namespace PhpTemplates;

use Closure;

// aka parsed template
class Template
{
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
     * Array of Template entities keyed by slot position
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
    /*
    public static function template($name, $data = [])
    {
        return new self($name, self::$templates[$name], $data);
    }*/
    
    /*
    public static function raw($name, \Closure $fn, $data = [])
    {
        if (!$name) {
            $name = uniqid();
        }
        return new self($name, $fn, $data);
    }*/
    
    public function __construct(TemplateRepository $repository, $name, \Closure $fn, $data = [])
    {
        $this->repository = $repository;
        $this->name = $name;
        $this->data = $data;
        
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
        $func(array_merge($this->repository->getSharedData(), $this->repository->getComposedData($this->name, $this->data), $this->scopeData));
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
    
    public function withSharedData(array $data)
    {
        $this->repository->shareData($data);
        
        return $this;
    }
    
    public function withDataComposers(array $data)
    {
        $this->repository->dataComposers($data);
        
        return $this;
    }
    
    public function template(string $name, array $data = []) 
    {
        return $this->repository->get($name, $data);
    }
}