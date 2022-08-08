<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNodeBindAttr;
use PhpTemplates\Dom\PhpNodeValAttr;

class ConfigHolder
{
    private $configs = [];
    
    public function __construct(Config $defaultConfig) 
    {
        $defaultConfig->configHolder($this);
        $this->configs['default'] = $defaultConfig;
        $this->addDefaultDirectives();
    }
    
    public function get(string $name = ''): Config
    {
        if (!$name) {
            return $this->configs['default'];
        }
        
        if ($name != $this->configs['default']->getName()) {
            return $this->merge($this->configs['default'], $this->configs[$name]);
        }
        
        return $this->configs[$name];
    }
    
    public function add(Config $config) 
    {
        $this->configs[$config->name] = $config;
    }
    
    // todo, remove
    public function getFrdhdhdhomFilePath(string $path, Config $fallback = null) 
    {
        $path = array_filter(explode(':', $name));
        if (count($path) > 1) {
            return $this->configs[$path[0]];
        }
        
        return $fallback;
    }
    
    public function merge($default, $cfg2) 
    {
        $cfg2 = clone $cfg2;
        
        foreach ($default->getDirectives() as $name => $directive) {
            if (!$cfg2->hasDirective($name)) {
                $cfg2->addDirective($name, $directive);
            }
        }
        
        foreach ($default->getAliases() as $alias => $name) {
            if (!$cfg2->hasAlias($alias)) {
                $cfg2->addAlias($alias, $name);
            }
        }
        
        return $cfg2;
    }
    
    private function addDefaultDirectives() 
    {
        $cfg = $this->configs['default'];
        
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
            $node->addAttribute(new PhpNodeValAttr('', $val . ' ? "selected=\"selected\" : ""'));
        });
        
        $cfg->addDirective('disabled', function(DomNode $node, string $val) {
            $node->addAttribute(new PhpNodeValAttr('', $val . ' ? "disabled" : ""'));
        });
    }
}