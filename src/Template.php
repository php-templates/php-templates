<?php

namespace PhpTemplates;

use Closure;
use PhpTemplates\Cache\CacheInterface;

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
    public $context = [];

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
    public static function template($name, $context = [])
    {
        return new self($name, self::$templates[$name], $context);
    }*/
    
    /*
    public static function raw($name, \Closure $fn, $context = [])
    {
        if (!$name) {
            $name = uniqid();
        }
        return new self($name, $fn, $context);
    }*/
    
    public function __construct(TemplateRepository $repository, $name, callable $fn, Context $context = null)
    {
        $this->repository = $repository;
        $this->name = $name;
        $this->context = $context;
        
        $this->func = $fn->bindTo($this);
    }
    
    public function slots($pos)
    {
        if (isset($this->slots[$pos])) {
            return $this->slots[$pos];
        }
        return [];
    }
    
    public function addSlot($pos, Closure $renderable)
    {
        $this->slots[$pos][] = $renderable;
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
    
    public function render()
    {
        //$this->context->merge($parentScope);
        //$this->scopeData = array_merge($parentScope, $this->context);
        //$this->scopeData['_name'] = $this->name;

        $func = $this->func;
        $func($this->context);
            
        //array_merge($this->repository->getSharedData(), $this->repository->getComposedData($this->name, $this->context), $this->scopeData));
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
    
    public function with(array $data = [])
    {
        if (!$this->context) {
            $this->context = new Context($data);
        } else {
            $this->context->merge($data);
        }
        
        return $this;
    }
    
    public function withShared(array $context)
    {
        $this->repository->shareData($context);
        
        return $this;
    }
    
    public function withComposers(array $context)
    {
        $this->repository->dataComposers($context);
        
        return $this;
    }
    
    public function template(string $name, Context $context = null) 
    {
        return $this->repository->get($name, $context);
    }
}