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
    
    public function setDefaultConfig(Config $config)
    {
        $config->configHolder($this);
        $this->defaultConfig = $config;
        $this->configs['default'] = $config;
    }
    
    public function getConfig(string $name): Config
    {
        return $this->configs[$name];
    }
    
    public function addConfig(Config $config) 
    {
        $this->configs[$config->name] = $config;
    }
}