<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class ForwardAttributeGroup extends AbstractAttributeGroup
{
    const WEIGHT = 1;
    
    public static function test(DomNodeAttr $attr): bool 
    {
        return $attr->nodeName && $attr->nodeName[0] == '@';
    }

    public function getNodeName(): string
    {
        return '_attrs';
    }
    
    public function toString(): string
    {
    }

    public function toArrayString(): string
    {
    }
}