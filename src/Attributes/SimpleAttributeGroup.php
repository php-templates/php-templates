<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class SimpleAttributeGroup extends AbstractAttributeGroup
{
    public function getNodeName(): string
    {
        return ltrim($this->attrs[0]->nodeName, ': ');
    }
    
    // todo documentat array class :class="[x => true]"
    public function toString(): string
    {
        $k = $this->getNodeName();
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $val = $this->toFullArrayString();
                return "$k=\"<?php echo attr_filter($val); ?>\"";
            }
        }
        
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] = $attr->nodeValue;
        }
        $val = implode(' ', $arr);
        if (empty($val)) {
            return $k;
        }
        
        return "$k=\"$val\"";        
    }

    public function toArrayString(): string
    {
        $k = $this->getNodeName();
        $arr = [];
        $attr_filter = false;
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $attr_filter = true;
                $arr[] = "{$attr->nodeValue}";
            }
            else {
                $arr[] = "'{$attr->nodeValue}'";
            }
        }
        
        if (empty($arr)) {
            $val = "''";
        } elseif ($attr_filter) {
            $val = '[' . implode(', ', $arr) . ']';
            $val = "attr_filter($val)";
        } else {
            $val = implode(' ', $arr);
        }
        
        return "'$k' => $val";
    }
    
    public function toFullArrayString(): string
    {
        return '[' . $this->toArrayString() . ']';
    }
}