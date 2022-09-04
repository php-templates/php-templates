<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

class StartupEntity implements EntityInterface
{
    private $config;
    private $name;
    
    public static function test(DomNode $node, EntityInterface $context)
    {
        return false;
    }
    
    public function __construct(Config $config, string $name = null) 
    {
        $this->config = $config;
        $this->name = $name;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function getName()
    {
        return $this->name;
    }
}