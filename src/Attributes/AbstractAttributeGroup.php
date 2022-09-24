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
    
    abstract public function bindArrayToNode(): string;
    abstract public function bindToNodeAttr(): string;
    abstract public function bindArrayToTemplate(): string;
    abstract public function bindToTemplateAttr(): string;
}