<?php

namespace PhpTemplates\Dom;

use PhpTemplates\Traits\IsContextual;

class PhpNodeBindAttr extends DomNodeAttr
{
    use IsContextual;
    
    public function __toString() 
    {
        return '<?php bind(' . $this->makeExpressionWithContext($this->nodeValue) . '); ?>';
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