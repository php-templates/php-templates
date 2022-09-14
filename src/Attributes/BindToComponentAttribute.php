<?php

namespace PhpTemplates\Attributes;

class BindToComponentAttribute extends AbstractAttribute
{
    const WEIGHT = 1;
    
    public static function test(DomNodeAttr $attr) {
        return $attr->nodeName && $attr->nodeName[0] == '@';
    }
    
    public function merge(AbstractAttribute $attr);
    public function toString();
    public function toArrayString();
}