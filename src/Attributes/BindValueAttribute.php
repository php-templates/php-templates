<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class BindValueAttribute extends AbstractAttribute
{
    const WEIGHT = 1;

    public static function test(DomNodeAttr $attr): bool
    {
        return $attr->nodeName && $attr->nodeName[0] == ':';
    }

    public function getNodeName(): string
    {
        return ltrim($this->attr->nodeName, ' :');
    }

    public function toString(): string
    {
        return '<?php echo ' . $this->attr->nodeValue . '; ?>';
    }

    public function toArrayString(): string
    {
        if ($this->attr->nodeName[0] == ':') {
            return $this->attr->nodeValue;
        }

        return "'{$this->attr->nodeValue}'";
    }
}