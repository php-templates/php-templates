<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNodeValAttr;
use PhpTemplates\Dom\PhpNodeBindAttr;

class Config
{
    private $parent;
    private $childs = [];
    
    private $name;

    private $srcPath;
    public $aliased = [];
    public $directives = [];
    
    private $prefix = 'p-';
   
    public function __construct($name, $srcPath, self $parent = null) {
        $this->parent = $parent;
        $this->name = $name;
        $this->srcPath = (array) $srcPath;
        if (!$this->parent) {
            $this->addDefaultDirectives();
        }
    }
    
    public function subconfig($name, $srcPath) 
    {
        $cfg = new Config($name, $srcPath, $this);
        $this->childs[] = $cfg;
  
        return $this;
    }
    
    public function getParent() {
        return $this->parent;
    }
    
    public function getRoot() {
        $cfg = $this;
        while ($this->getParent()) {
            $cfg = $this->getParent();
        }
        
        return $cfg;
    }
// set = may replace, add = push
    public function addDirective(string $key, \Closure $callable): void
    {//$key == 'guest' && d('$$$$$');
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
        $cfg = $this;
        do {
            if (isset($cfg->aliased[$name])) {
                return $cfg->aliased[$name];
            }
        }
        while ($cfg = $cfg->getParent());
    }
    
    public function dydydhasAlias(string $name) 
    {
        return isset($this->aliased[$name]);
    }
    
    public function djdjdjgetAliases() 
    {
        return $this->aliased;
    }
    
    public function getDirective(string $name) 
    {
        $cfg = $this;
        do {
            if (isset($cfg->directives[$name])) {
                return $cfg->directives[$name];
            }
        }
        while ($cfg = $cfg->getParent());
    }
    public function hadjfjfjsDirective(string $name) 
    {
        return isset($this->directives[$name]);
    }
    
    public function dhfhfhgetDirectives() 
    {
        return $this->directives;
    }
    
    public function isDefault() 
    {
        return !$this->parent;
    }
    
    public function find(string $cfgkey) {
        if ($this->name == $cfgkey) {
            return $this;
        }
        foreach ($this->childs as $child) {
            if ($cfg = $child->find($cfgkey)) {
                return $cfg;
            }
        }//die('3');
    }
    
    private function addDefaultDirectives() 
    {
        $cfg = $this;
        $controlStructures = ['if', 'elseif', 'else', 'for', 'foreach'];
        
        foreach ($controlStructures as $statement) {
            $cfg->addDirective($statement, function(DomNode $node, string $val) use ($statement) {
                $phpnode = new PhpNode($statement, $args);
                $node->parentNode->insertBefore($phpnode, $node);
                $phpnode->appendChild($node->detach());
            });
        }
        
        $cfg->addDirective('raw', function(DomNode $node, string $val) {
            $node->addAttribute(new PhpNodeValAttr('', $val));
        });
        
        $cfg->addDirective('bind', function(DomNode $node, string $val) {
            $node->addAttribute(new PhpNodeBindAttr('', $val));
        });
        
        $cfg->addDirective('checked', function(DomNode $node, string $val) {
            $node->addAttribute(new PhpNodeValAttr('', $val . ' ? "checked" : ""'));
        });
        
        $cfg->addDirective('selected', function(DomNode $node, string $val) {
            $node->addAttribute(new PhpNodeValAttr('', $val . ' ? "selected=\"selected\"" : ""'));
        });
        
        $cfg->addDirective('disabled', function(DomNode $node, string $val) {
            $node->addAttribute(new PhpNodeValAttr('', $val . ' ? "disabled" : ""'));
        });
    }
    
    public function __dhdhdget($prop)
    {
        return isset($this->{$prop}) ? $this->{$prop} : null;
    }
}