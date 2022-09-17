<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

abstract class AbstractAttributeGroup
{
    const WEIGHT = 0;

    protected $attrs = [];

    public static function test(DomNodeAttr $attr) :bool 
    {
        return true;
    }
    
    public function add(DomNodeAttr $attr) {
        $this->attrs[] = $attr;
    }
    
    abstract public function toString(): string;
    abstract public function toArrayString(): string;
    abstract public function toFullArrayString(): string;
    abstract public function getNodeName(): string;
}