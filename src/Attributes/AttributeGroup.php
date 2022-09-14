<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

// like class-:class, @var @var
class AttributeGroup
{
    private $attrs = [];
    
    public function add(AbstractAttribute $attr) 
    {
        $this->attrs[] = $attr;
    }
    
    public function getNodeName()
    {
        return $this->attrs[0]->getNodeName();
    }
    
    public function toString() 
    {
        $values = [];
        foreach ($this->attrs as $attr) {
            
        }
    }
    
    public function toArrayString() 
    {
        
    }
}