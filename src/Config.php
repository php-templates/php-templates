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
        $this->srcPath = (array) $srcPath;
    }
    
    public function configHolder(ConfigHolder $holder): self
    {
        $this->configHolder = $holder;
        return $this;
    }

    public function addDirective(string $key, \Closure $callable): void
    {
        $this->directives[$key] = $callable;
    }
    
    public function addAlias($key, string $component = ''): void
    {
        if (!is_array($key)) {
            $aliased = [$key => $component];
        } else {
            $aliased = $key;
        }
        $this->aliased = array_merge($this->aliased, $aliased);
    }

    public function hashhhDirective(string $key): bool
    {
        return isset($this->directives[$key]);
    }
    
    public function hasbbbAlias(string $key): bool
    {
        return isset($this->aliased[$key]);
    }
    
    public function setSrcPath($val)
    {
        $this->srcPath = $val;
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getPath() 
    {
        return $this->srcPath;
    }
    public function addPath(string $path) 
    {
        $this->srcPath[] = $path;
    }
    
    public function getName() 
    {
        return $this->name;
    }
    
    public function getAliased(string $name) 
    {
        return $this->aliased[$name] ?? null;
    }
    public function hasAlias(string $name) 
    {
        return isset($this->aliased[$name]);
    }
    public function getAliases() 
    {
        return $this->aliased;
    }
    
    public function getDirective(string $name) 
    {
        return $this->directives[$name] ?? null;
    }
    public function hasDirective(string $name) 
    {
        return isset($this->directives[$name]);
    }
    
    public function getDirectives() 
    {
        return $this->directives;
    }
    
    public function __get($prop)
    {
        return isset($this->{$prop}) ? $this->{$prop} : null;
    }
}