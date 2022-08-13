<?php

namespace PhpTemplates\Dom;

class PhpNodeValAttr extends DomNodeAttr
{
    private $merged = [];
   
    public function __toString() 
    {
        $name = ltrim($this->nodeName, ':@');
        if (!$this->merged) {
            if (!$name) {
                return '<?php e(' . $this->nodeValue . '); ?>';
            }
            return $name .'="<?php e(' . $this->nodeValue . '); ?>"';
        }
        $val = [];
        foreach ($this->merged as $attr) {
            $val[] = $attr->valueString();
        }
        $val[] = $this->nodeValue;
        $val = implode(', ', $val);
        
        $val = '<?php attr(' . $val . '); ?>';
        //d('--'.$this->nodeName);
        if (!$this->nodeName) {
            return $val;
        }
        
        return $name . '="' . $val . '"';
    }
    
    public function toArrayString()
    {
        $name = ltrim($this->nodeName, ':@');
        if (!$this->merged) {
            return "'". addslashes($name) . "' => " . $this->nodeValue;
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