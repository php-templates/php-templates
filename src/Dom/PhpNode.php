<?php

namespace PhpTemplates\Dom;

class PhpNode extends DomNode
{
    public function __toString()
    {
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        
        if ($this->nodeValue || $this->nodeValue == '0') {
            $expr = "{$this->nodeName} ({$this->nodeValue})";
        } else {
            $expr = $this->nodeName;
        }
        $return .= "<?php $expr { ?>";
        
        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }
        
        // NODE END
        $return .= $indentNL . '<?php } ?>';
        
        return $return;
    }
    
    public function getNodeName()
    {
        return '#php-'.$this->nodeName;
    }
}