<?php

namespace PhpTemplates\Dom;

class DomNodeAttr
{
    public $nodeName;
    public $nodeValue;
     
    public function __construct(string $nodeName, string $nodeValue = '') 
    {
        $this->nodeName = $nodeName;
        $this->nodeValue = $nodeValue;
    }
    
    public function __toString() 
    {
        if (!$this->nodeName) {
            return $this->nodeValue;
        }
        elseif (!$this->nodeValue) {
            return $this->nodeName;
        }
        return $this->nodeName . '="' . $this->nodeValue . '"';
    }
    // todo remove below
    public function toArrayString()
    {
        return "'" . addslashes($this->nodeName) . "' => '" . addslashes($this->nodeValue) . "'";
    }
    
    public function valueStrung()
    {
        return "'" . addslashes($this->nodeValue) . "'";
    }
    
    public function merge(DomNodeAttr $attr) 
    {
        $this->nodeValue .= ' ' . trim($attr->nodeValue);
    }
    
    public function valueString()
    {
        return "'" . addslashes($this->nodeValue) . "'";
    }
}