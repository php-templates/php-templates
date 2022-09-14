<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class SimpleAttributeGroup extends AbstractAttributeGroup
{
    public function getNodeName(): string
    {
        return ltrim($this->attrs[0]->nodeName, ': ');
    }
    
    public function toString(): string
    {
        $k = $this->getNodeName();
        $arr = [];
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $arr[] = "<?php echo {$attr->nodeValue}; ?>";
            }
            else {
                $arr[] = $attr->nodeValue;
            }
        }
        $val = implode(' ', $arr);
        //$val = addslashes($val);
        
        return "$k=\"$val\"";        
    }

    public function toArrayString(): string
    {
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
        //$val = addslashes($val);
        
        return "$k => $val";
    }
}