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
    public function toString(): string
    {
        $attr = $this->attrs[0];
        
        return "<?php echo {$attr->nodeValue}; ?>";
    }

    public function toArrayString(): string
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
    
    public function toFullArrayString(): string
    {
        return '';
    }
}