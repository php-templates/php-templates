<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;
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
    
    private $prefix = 'p-'; // todo: find and remove
   
    public function __construct($name, $srcPath, self $parent = null) {
        $this->parent = $parent;
        $this->name = $name;
        $this->srcPath = (array) $srcPath;
        if (!$this->parent) {
            $this->addDefaultDirectives();
        }
    }
    
    public function subconfig($name, $srcPath) 
    {// todo: ensure existing is taken
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

    public function setDirective(string $key, \Closure $callable): void
    {
        $reserved = ['raw', 'bind', 'if', 'elseif', 'else', 'for', 'foreach'];
        
        if (in_array($key, $reserved)) {
            throw new \Exception("System directive '$key' cannot be overriden");
        }
        
        $this->directives[$key] = $callable;
    }
    
    public function setAlias($key, string $component = ''): void
    {
        if (!is_array($key)) {
            $aliased = [$key => $component];
        } else {
            $aliased = $key;
        }
        $this->aliased = array_merge($this->aliased, $aliased);
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
        }
    }
    
    private function addDefaultDirectives() 
    {
        $cfg = $this;
        $controlStructures = ['if', 'elseif', 'else', 'for', 'foreach'];
        
        foreach ($controlStructures as $statement) {
            $this->directives[$statement] = function(DomNode $node, string $args) use ($statement) {
                if (in_array($statement, ['elseif', 'else'])) {
                    if (!$node->prevSibling || !in_array(str_replace('#php-', '', $node->prevSibling->nodeName), ['if', 'elseif'])) {//$node->parentNode->parentNode->d();dd($node->parentNode->parentNode->debug());
                        throw new InvalidNodeException("Unespected control structure '$statement'", $node);
                    }
                }
                $phpnode = new PhpNode($statement, $args);
                $phpnode->indentStart = $node->indentStart;
                $phpnode->indentEnd = $node->indentEnd;
   
                $node->parentNode->insertBefore($phpnode, $node);
                $phpnode->appendChild($node->detach());
            };
        }
        
        $cfg->setDirective('checked', function(DomNode $node, string $val) {
            $node->addAttribute('p-raw', $val . ' ? "checked" : ""');
        });
        
        $cfg->setDirective('selected', function(DomNode $node, string $val) {
            $node->addAttribute('p-raw', $val . ' ? "selected=\"selected\"" : ""');
        });
        
        $cfg->setDirective('disabled', function(DomNode $node, string $val) {
            $node->addAttribute('p-raw', $val . ' ? "disabled" : ""');
        });
    }
    
    public function __dhdhdget($prop)
    {
        return isset($this->{$prop}) ? $this->{$prop} : null;
    }
}