<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

class StartupEntity implements EntityInterface
{
    private $config;
    
    public static function test(DomNode $node, EntityInterface $context)
    {
        return false;
    }
    
    public function __construct(Config $config) 
    {
        $this->config = $config;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}