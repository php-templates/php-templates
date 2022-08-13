<?php

namespace PhpTemplates\Dom;

class PhpNodeBindAttr extends DomNodeAttr
{
    
    public function __toString() 
    {
        return '<?php bind(' . $this->nodeValue . '); ?>';
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
        $val = 'attr(' . implode(', ', $val) . ')';
        return "'". addslashes($this->nodeName) . "' => " . $val;
    }
}