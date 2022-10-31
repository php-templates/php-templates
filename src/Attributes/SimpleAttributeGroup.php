<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class SimpleAttributeGroup extends AbstractAttributeGroup
{
    public function getNodeName(): string
    {
        return ltrim($this->attrs[0]->nodeName, ': ');
    }

    public function bindToNodeAttr(): string
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                return $this->bindAttrFilterToNodeAttr();
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

    public function bindToTemplateAttr(): string
    {
        $k = $this->getNodeName();

        $arr = [];
        $binds = false;
        $normal = false;
        $bindArr = false;
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $binds = true;
                $arr[] = "{$attr->nodeValue}";
                $bindArr = $bindArr || trim($attr->nodeValue)[0] == '[';
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

    public function bindArrayToNode(): string
    {
        return '[' . $this->bindToTemplateAttr() . ']';
    }

    public function bindArrayToTemplate(): string
    {
        $k = $this->getNodeName();

        $arr = [];
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
                $arr[] = "{$attr->nodeValue}";
            }
            else {
                $arr[] = "'{$attr->nodeValue}'";
            }
        }
        $val = end($arr);

        return "['$k' => $val]";
    }

    public function toFullArrayString(): string
    {
        return '[' . $this->toArrayString() . ']';
    }

    private function bindAttrFilterToNodeAttr()
    {
        $k = $this->getNodeName();
        $arr = [];
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName[0] == ':') {
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