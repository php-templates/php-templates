<?php

namespace PhpTemplates;

class Config
{
    const allowedControlStructures = [
        'if', 'elseif', 'else', 'for', 'foreach'
    ];
    
    const attrCumulative = [
        'class', 'id'
    ];
    
    private $prefix = 'p-';
    private $srcPath;
    private $destPath;
    private $trackChanges = true; // TODO:
    private $aliased = [];
    private $directives = [];
   
    public function __construct($srcPath, $destPath) {
        $this->srcPath = $srcPath;
        $this->destPath = $destPath;
    }
    
    //const attrDataBindEager = 'data';
    //const attrIsComponent = 'is';

    public function addDirective(string $key, \Closure $callable): void
    {
        $this->directives[$key] = $callable;
    }
    
    public function addAlias(string $key, string $component): void
    {
        $this->aliased[$key] = $component;
    }
    
    public function setSrcPath(string $val)
    {
        $this->srcPath = $val;
    }
    
    public function setDestPath(string $val)
    {
        $this->destPath = $val;
    }
    
    public function merge(Config $cfg)
    {
        $this->aliased = array_merge($cfg->aliased, $this->aliased);
        $this->directives = array_merge($cfg->directives, $this->directives);
    }
    
    public function __get($prop)
    {
        return isset($this->{$prop}) ? $this->{$prop} : null;
    }
}