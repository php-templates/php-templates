<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class AttributePack extends DomNodeAttr
{
    private $attrs = [];

    public function __construct()
    {

    }

    public function add(DomNodeAttr $attr)
    {
        $this->attrs[] = $attr;
    }

    public function __toString()
    {
        $normalNodes = [];
        $arrayNodes = [];
        foreach ($this->attrs as $attr) {
            $isSpecialNode = $attr->nodeName && ($attr->nodeName[0] == ':' || in_array($attr->nodeName, ['p-bind', 'p-raw']));
            $_val = trim($attr->nodeValue) === '' ? "true" : $attr->nodeValue;
            if (in_array($attr->nodeName, ['p-bind', 'p-raw'])) {
                $arrayNodes[] = $_val;
            }
            elseif (strpos($attr->nodeName, ':') === 0) {
                $arrayNodes[] = "['" . ltrim($attr->nodeName, ':') . "' => " . $_val . ']';
            }
            else {
                $arrayNodes[] = "['" . $attr->nodeName . "' => '". addslashes($attr->nodeValue) . "']";
            }
            
            if (is_null($normalNodes) || $isSpecialNode) {
                $normalNodes = null; // close normal nodes codeflow
                continue;
            }
            $normalNodes[] = $this->attrToString($attr);
        }
        
        if (!is_null($normalNodes)) {
            // only normal nodes found
            return implode(' ', $normalNodes);
        }
        
        $result = implode(', ', $arrayNodes);
        
        return "<?php e_attrs($result); ?>";
    }

    public function toArrayString()
    {
        // we need a structure like [[foo=>bar], ...] where each element is an attribute, because there are cases like :class="[]" or p-bind and we need to cover them. It may be a performance issue, TODO:
        $arrayNodes = [];
        foreach ($this->attrs as $attr) {
            $_val = trim($attr->nodeValue) === '' ? "true" : $attr->nodeValue;
            if (in_array($attr->nodeName, ['p-bind', 'p-raw'])) {
                $arrayNodes[] = $_val;
            }
            elseif (trim($attr->nodeValue) === '' || strpos($attr->nodeName, ':') === 0) {
                $arrayNodes[] = "['" . ltrim($attr->nodeName, ':') . "' => " . $_val . ']';
            }
            else {
                $arrayNodes[] = "['" . $attr->nodeName . "' => '". addslashes($_val) . "']";
            }
        }
        
        $result = implode(', ', $arrayNodes);
        
        return "r_attrs($result)";
    }
    
    private function attrToString(DomNodeAttr $attr) 
    {
        if (!$attr->nodeName || $attr->nodeName == 'p-bind') {
            return $attr->nodeValue;
        }
        
        return ltrim($attr->nodeName, '@: ') . ($attr->nodeValue ? '="' . $attr->nodeValue . '"' : '');
    }
}
