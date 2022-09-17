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
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                return $this->toString2();
            }
        }
        
        $k = $this->getNodeName();
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
        $binds = false;
        $normal = false;
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $binds = true;
                $arr[] = "{$attr->nodeValue}";
            }
            else {
                $normal = true;
                $arr[] = "'{$attr->nodeValue}'";
            }
        }
        
        if (empty($arr)) {
            $val = "''";
        } elseif ($binds && $normal) {
            $val = '[' . implode(', ', $arr) . ']';
            $val = "attr_filter($val)";
        }
        else {
            $val = implode(' ', $arr);
        }
        
        return "'$k' => $val";
    }
    
    public function toFullArrayString(): string
    {
        return '[' . $this->toArrayString() . ']';
    }
    
    private function toString2()
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
            $val = '[]';
        } else {
            $val = '[' . implode(', ', $arr) . ']';
        }
        
        return "$k=\"<?php echo attr_filter($val); ?>\"";     
    }
}