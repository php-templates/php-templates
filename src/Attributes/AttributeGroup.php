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
        $arr = [];

        // @attr1, @attr2 => foo="bar" bam="baz"
        // :attr1, attr1 => attr
        foreach ($this->attrs as $attr) {
            $arr[] = $attr->toString();
        }

        return implode(' ', $arr);
    }
    
    public function toArrayString() 
    {
        $arr = [];

        // @attr1, @attr2 => _attrs => [foo:bar, bam:baz]
        foreach ($this->attrs as $attr) {
            $arr[] = $attr->toArrayString(); //'foo', bar
        }

        $k = $this->getNodeName();

        return "'$k' => [" . implode(', ', $arr) . "]";
    }
}