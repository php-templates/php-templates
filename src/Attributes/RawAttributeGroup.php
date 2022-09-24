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
    
    // todo documentat array class :class="[x => true]"
    public function bindToNodeAttr(): string
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] =  "<?php echo {$attr->nodeValue}; ?>";
        }
        
        return implode(' ', $arr);
    }

    public function bindToTemplateAttr(): string
    {dd('todo rawattrgroup');
        $k = $this->getNodeName();
        $arr = [];
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $arr[] = "({$attr->nodeValue})";
            }
            else {
                $arr[] = "'{$attr->nodeValue}'";
            }
        }
        $val = implode(".' '.", $arr);
        if (empty($val)) {
            $val = "''";
        }
        
        return "'$k' => $val";
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