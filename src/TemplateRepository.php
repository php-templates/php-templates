<?php

namespace PhpTemplates;

use Closure;
use PhpTemplates\Cache\CacheInterface;

// todo rename into ViewFactory
class TemplateRepository
{
    protected $templates;
    protected $eventHolder;
    protected $composers = [];
    
    protected $shared = [];
    protected $composed = [];
    
    
    public function __construct(CacheInterface $cache, EventHolder $eventHolder) 
    {
        $this->cache = $cache;
        $this->eventHolder = $eventHolder;
    }
    
    public function share(array $data) 
    {
        $this->shared = array_merge($this->shared, $data);
    }
    
    public function composers(array $data) 
    {
        $this->composers = array_merge($this->composers, $data);
    }
    
    public function getShared() 
    {
        return $this->shared;
    }
    
    public function compose(string $name, $existingData = []) 
    {
        if (empty($this->composers[$name])) {
            return [];
        } 
        elseif (isset($this->composed[$name])) {
            return $this->composed[$name];
        }
        
        $data = [];
        foreach ($this->composers[$name] as $cb) {
            $data = array_merge($data, $cb($existingData));
        }
        
        $this->composed = $data;
        
        return $data;
    }
    
    public function add(string $name, Closure $fn) 
    {
        $this->templates[$name] = $fn;
    }
    
    public function get(string $name, Context $context = null) 
    {
        //$data = array_merge((array)$this->shared, $data);
        return new Template($this, $name, $this->cache->get($name), $context);
    }
    
    public function getEventHolder() 
    {
        return $this->eventHolder;
    }
}