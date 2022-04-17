<?php

namespace PhpTemplates;

class Parser 
{
    // other process stuffs
    
    public function __construct($configs)
    {
        
    }
    
    public function parseNode($node)
    {
        
    }
    
    public function parseFile(string $rfilepath)
    {
        // get config from prefix
        // init entities with prefix
    }
    
    public function withConfig(string $key)
    {
        $this->config = $this->configs[$key];
        return $this;
    }
    
    public function parse($rfilepath)
    {
        $comp = new TemplateFunction($this, $rfilepath);
        $comp->parse();
    }
    
    public function parseNode()
    {
        
    }
    
    public function getResult()
    {
        
    }
}