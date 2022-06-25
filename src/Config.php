<?php

namespace PhpTemplates;

class Config
{
    private $name;

    private $srcPath;
    private $aliased = [];
    private $directives = [];

    const allowedControlStructures = [
        'if', 'elseif', 'else', 'for', 'foreach'
    ];
    
    const attrCumulative = [
        'class', 'id'
    ];
    
    private $prefix = 'p-';
   
    public function __construct($name, $srcPath) {
        $this->name = $name;
        $this->srcPath = $srcPath;
    }

    public function addDirective(string $key, \Closure $callable): void
    {
        $this->directives[$key] = $callable;
    }
    
    public function addAlias(string $key, string $component): void
    {
        $this->aliased[$key] = $component;
    }

    public function hasDirective(string $key): bool
    {
        return isset($this->directives[$key]);
    }
    
    public function hasAlias(string $key): bool
    {
        return isset($this->aliased[$key]);
    }
    
    public function setSrcPath($val)
    {
        $this->srcPath = $val;
    }
    
    public function __get($prop)
    {
        return isset($this->{$prop}) ? $this->{$prop} : null;
    }
}