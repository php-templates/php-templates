<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class ForwardAttribute extends AbstractAttribute
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
        $k = ltrim($this->attr->nodeName, ' @');

        return $k . '="<?php echo ' . $this->attr->nodeValue . '; ?>"';
    }

    public function toArrayString(): string
    {
        $k = ltrim($this->attr->nodeName, ' @');

        return "$k => {$this->attr->nodeValue}";
    }
}