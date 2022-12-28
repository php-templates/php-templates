<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;

/**
 * Wrapper used to initialize parse process
 */
class StartupEntity extends AbstractEntity
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

    public function templateContext()
    {
    }
    public function slotContext()
    {
    }
    public function simpleNodeContext()
    {
    }
    public function anonymousContext()
    {
    }
    public function verbatimContext()
    {
    }
    public function textNodeContext()
    {
    }
    public function extendContext()
    {
    }
}