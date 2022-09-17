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
        if (count($this->attrs) === 1) {
            $attr = $this->attrs[0];
            return "<?php bind({$attr->nodeValue}); ?>";
        }
        
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] = $attr->nodeValue;
        }
        $val = '<?php bind(array_merge(' . implode(', ', $arr) . ')); ?>';
     
        return $val;              
    }

    public function toArrayString(): string
    {
        if (count($this->attrs) === 1) {
            $attr = $this->attrs[0];
            return $attr->nodeValue;
        }
        
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] = $attr->nodeValue;
        }
        $val = 'attr_merge(' . implode(', ', $arr) . ')';
     
        return $val;        
    }
    
    public function toFullArrayString(): string
    {
        return $this->toArrayString();
    }
}