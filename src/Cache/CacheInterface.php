<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Template;
use PhpTemplates\Dom\Source;
use Closure;

interface CacheInterface
{
    public function load(string $key): bool;
    
    public function has(string $key): bool;
    
    public function set(string $key, callable $fn, Source $source = null): void;
    
    public function get(string $key): callable;
    
//public function clear(): void;
    
   
}