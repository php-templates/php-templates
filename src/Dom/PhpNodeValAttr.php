<?php

namespace PhpTemplates\Dom;

use PhpTemplates\Traits\IsContextual;

class PhpNodeValAttr extends DomNodeAttr
{
    use IsContextual;
    
    private $merged = [];
   
    public function __toString() 
    {
        $name = ltrim($this->nodeName, ':@');
        if (!$this->merged) {
            return $name .'="<?php e(' . $this->makeExpressionWithContext($this->nodeValue) . '); ?>"';
        }
        $val = [];
        foreach ($this->merged as $attr) {
            $val[] = $attr->valueString();
        }
        $val[] = $this->nodeValue;
        $val = implode(', ', $val);
        
        $val = '<?php attr(' . $this->makeExpressionWithContext($val) . '); ?>';
        
        return $name . '="' . $val . '"';
    }
    
    public function toArrayString()
    {
        $name = ltrim($this->nodeName, ':@');
        if (!$this->merged) {
            return "'". addslashes($name) . "' => " . $this->makeExpressionWithContext($this->nodeValue);
        }dd('nu va merge');
        $val = [];
        foreach ($this->merged as $attr) {
            $val[] = $attr->valueString();
        }
        $val[] = $this->nodeValue;
        $val = 'attr(' . implode(', ', $val) . ')';
        return "'". addslashes($name) . "' => " . $val;
    }
    
    public function valueString()
    {
        return $this->nodeValue;
    }
    
    public function merge(DomNodeAttr $attr) 
    {
        $this->merged[] = $attr;
    }
}