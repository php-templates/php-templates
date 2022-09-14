<?php

namespace PhpTemplates\Attributes;

class AbstractAttribute
{
    const WEIGHT = 0;
    
    public static function test(DomNodeAttr $attr) {
        return true;
    }
    
    abstract public function merge(AbstractAttribute $attr);
    abstract public function toString();
    abstract public function toArrayString();
    abstract public function getNodeName();
}