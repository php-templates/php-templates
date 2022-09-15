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
        $arr = [];
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                if (strpos(trim($attr->nodeValue), '[') === 0) {
                    $arr[] = "<?php attr({$attr->nodeValue}); ?>";
                } else {
                    $arr[] = "<?php echo {$attr->nodeValue}; ?>";
                }
            }
            else {
                $arr[] = $attr->nodeValue;
            }
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
}