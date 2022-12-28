<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

/**
 * Wrapper used to initialize parse process
 */
class StartupEntity implements AbstractEntity
{
    private $config;
    private $name;

    public function __construct(Config $config, string $name = '')
    {
        $this->config = $config;
        $this->name = $name;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getName(): string
    {
        return $this->name;
    }
}