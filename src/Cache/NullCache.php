<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Template;
use PhpTemplates\EventHolder;
use PhpTemplates\Source;

class NullCache implements CacheInterface
{
    protected $store = [];
    
    public function load(string $key): bool
    {
        return false;
    }
    
    public function has(string $key): bool
    {
        return isset($this->store[$key]);
    }
    
    public function set(string $key, callable $fn, Source $source = null): void
    {
        $this->store[$key] = $fn;
    }
    
    public function get(string $key): callable
    {
        return $this->store[$key] ?? null;
    }
    
    public function write(string $key) {}
}
