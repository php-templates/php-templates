<?php

namespace PhpTemplates;

class ParsedTemplate
{
    private $name;
    private $config;
    private $definition;
    private $next;
    
    public function __construct(string $name, Config $config, TemplateClassDefinition $definition, ?ParsedTemplate $next = null) 
    {
        $this->name = $name;
        $this->config = $config;
        $this->definition = $definition;
        $this->next = $next;
    }
}
