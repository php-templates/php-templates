<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

abstract class AbstractAttribute
{
    const WEIGHT = 0;

    protected $attr;
    
    public function __construct(DomNodeAttr $attr) 
    {
        $this->attr = $attr;
    }

    public static function test(DomNodeAttr $attr) :bool 
    {
        return true;
    }
    
    abstract public function toString(): string;
    abstract public function toArrayString(): string;
    abstract public function getNodeName(): string;
}