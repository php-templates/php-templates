<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;
//use DomDocument\PhpTemplates\Template;
//use DomDocument\PhpTeplates\Parsable;

class Document
{
    protected $functions = [];
    protected $content = '';
    
    public function registerFunction($name, $content)
    {
        $this->functions[$name] = $content;
    }
    
    public function hasFunction($fnName)
    {
        return isset($this->functions[$fnName]);
    }
    
    public function getFunctions()
    {
        return $this->functions;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($c)
    {
        $this->content = $c;
    }
}