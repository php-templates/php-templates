<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class BindArrayAttributeGroup extends AbstractAttributeGroup
{
    const WEIGHT = 1;
    
    public static function test(DomNodeAttr $attr): bool 
    {
        return $attr->nodeName == 'p-bind';
    }

    public function getNodeName(): string
    {
        return 'p-bind';
    }
    
    public function toString(): string
    {
    }

    public function toArrayString(): string
    {
    }
}