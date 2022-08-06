<?php

namespace PhpTemplates\Dom;

use PhpTemplates\Traits\IsContextual;

class PhpNode extends DomNode
{
    use IsContextual;
    
    public function __toString()
    {
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        
        if ($this->nodeName && $this->nodeName != '#text' && ($this->nodeValue || $this->nodeValue == '0')) {
            $expr = "{$this->nodeName} ({$this->nodeValue}) {";
        } 
        elseif($this->nodeName && $this->nodeName != '#text') {
            $expr = $this->nodeName . ' {';
        }
        else {
            $expr = $this->nodeValue . ';';
        }
        $return .= '<?php ' . $this->makeExpressionWithContext($expr) . ' ?>';
        
        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }
        
        // NODE END
        if ($this->nodeName && $this->nodeName != '#text') {
            $return .= $indentNL . '<?php } ?>';
        }
        
        return $return;
    }
    
    public function getNodeName()
    {
        return '#php-'.$this->nodeName;
    }
}