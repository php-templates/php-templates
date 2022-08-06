<?php

namespace PhpTemplates\Dom;

class DomNodeRawAttr
{
    public function __toString() 
    {dd('todo');
        if (!$this->nodeName) {
            return $this->nodeValue;
        }
        return $this->nodeName . '="' . $this->nodeValue . '”';
    }
    
    public function toArrayString()
    {dd('todo');
        if (!$this->merged) {
            return "'". addslashes($this->nodeName) . "' => " . $this->nodeValue;
        }
        $val = [];
        foreach ($this->merged as $attr) {
            $val[] = $attr->valueString();
        }
        $val[] = $this->nodeValue;
        $val = 'attr(' . implode(', ' $val); . ')';
        return "'". addslashes($this->nodeName) . "' => " . $val;
    }
}