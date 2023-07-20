<?php

namespace PhpTemplates;

use PhpDom\Contracts\DomElementInterface

class ParsedTemplate
{
    private $file;
    private $name;
    private $config;
    private $definition;
    
    public function __construct(string $file, string $name, Config $config, TemplateClassDefinition $definition, ) 
    {
        $this->file = $file;
        $this->name = $name;
        $this->config = $config;
        $this->definition = $definition;
    }

    public function getClassDefinition(): TemplateClassDefinition
    {
        return $this->definition;
    }
    
    public function getName() 
    {
        return $this->name;
    }
    
    public function getUseStmts() 
    {
        return $this->definition->getUseStmts();
    }
    
    public function getFile() 
    {
        return $this->file;
    }
}
