<?php

namespace PhpTemplates;

use Closure;
use PhpTemplates\Cache\CacheInterface;

// todo rename into view
class Template
{
    /**
     * called template function name
     * @var string
     */
    protected $name;

    /**
     * Data passed to component using node attributes
     *
     * @var Context
     */
    public $context;

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

    public $comp; //TODO: findout
    
    public function __construct(ViewFactory $repository, $name, callable $fn, Context $context = null)
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

    public function setIdjfjfjfndex($i)
    {
        $this->attrs['_index'] = $i;

        return $this;
    }
    
    public function render()
    {
        $eventHolder = $this->repository->getEventHolder();
        $eventHolder->event('rendering', $this->name, $this->context);
        //TODO render event
        $func = $this->func;
        $func($this->context);
    }
    
    public function __gfjfjfet($prop)
    {
        if (isset($this->{$prop})) {
            return $this->{$prop};
        }
    }
    
    public function withfjfhfhName($name)
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
    
    public function witdjfjdjhShared(array $context)
    {
        $this->repository->share($context);
        
        return $this;
    }
    
    public function withfhfhfhComposers(array $context)
    {
        $this->repository->composers($context);
        
        return $this;
    }
    
    public function template(string $name, Context $context = null) 
    {
        return $this->repository->get($name, $context);
    }
}