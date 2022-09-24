<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class ForwardAttributeGroup extends AbstractAttributeGroup
{
    const WEIGHT = 1;
    
    public static function test(DomNodeAttr $attr): bool 
    {
        return $attr->nodeName && $attr->nodeName[0] == '@' && strpos($attr->nodeName, '@php') !== 0;
    }

    public function getNodeName(): string
    {
        return '_attrs';
    }
    
    public function bindToNodeAttr(): string
    {
        $arr = [];
        
        foreach ($this->attrs as $attr) {
            $k = ltrim($attr->nodeName, ' @');
            $arr[] = $k . '="<?php echo ' . $attr->nodeValue . '; ?>"';
        }
        
        return implode(' ', $arr);
    }

    public function bindToTemplateAttr(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $k = ltrim($attr->nodeName, ' @');
            $arr[] = "'$k' => " . $attr->nodeValue;
        }
        $val = "'_attrs' => [" . implode(', ', $arr) . ']';
        
        return $val;
    }
    
    public function bindArrayToNode(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $k = ltrim($attr->nodeName, ' @');
            $arr[] = "'$k' => " . $attr->nodeValue;
        }
        
        return '[' . implode(', ', $arr) . ']';
    }
    
    public function bindArrayToTemplate(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $k = ltrim($attr->nodeName, ' @');
            $arr[] = "'$k' => " . $attr->nodeValue;
        }
        $val = "['_attrs' => [" . implode(', ', $arr) . ']]';
        
        return $val;
    }
    
    public function toFullArrayString(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $k = ltrim($attr->nodeName, ' @');
            $arr[] = "'$k' => " . $attr->nodeValue;
        }
        $val = '[' . implode(', ', $arr) . ']';
        
        return $val;
    }
}