<?php

namespace PhpTemplates;

class ConfigHolder
{
    private $defaultConfig;
    private $configs = [];
    
    public function __construct(Config $defaultConfig) 
    {
        $defaultConfig->configHolder($this);
        $this->defaultConfig = $defaultConfig;
        $this->configs['default'] = $defaultConfig;
    }
    
    public function setDefault(Config $config)
    {
        $config->configHolder($this);
        $this->defaultConfig = $config;
        $this->configs['default'] = $config;
    }
    
    public function get(string $name = ''): Config
    {
        if (!$name) {
            return $this->defaultConfig;
        }
        
        if ($name != $this->defaultConfig->getName()) {
            return $this->merge($this->defaultConfig, $this->configs[$name]);
        }
        
        return $this->configs[$name];
    }
    
    public function add(Config $config) 
    {
        $this->configs[$config->name] = $config;
    }
    
    // todo, remove
    public function getFromFilePath(string $path, Config $fallback = null) 
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
}