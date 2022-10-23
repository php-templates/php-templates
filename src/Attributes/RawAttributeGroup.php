<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class RawAttributeGroup extends AbstractAttributeGroup
{
    const WEIGHT = 2;

    public static function test(DomNodeAttr $attr): bool
    {
        return $attr->nodeName == 'p-raw';
    }

    public function getNodeName(): string
    {
        return '';
    }
    
    public function bindToNodeAttr(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] =  "<?php echo {$attr->nodeValue}; ?>";
        }

        return implode(' ', $arr);
    }

    public function bindToTemplateAttr(): string
    {
        return '[]';
    }

    public function bindArrayToNode(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] =  $attr->nodeValue;
        }

        return '[' . implode(', ', $arr) . ']';
    }

    public function bindArrayToTemplate(): string
    {
        return '[]';
    }
}
