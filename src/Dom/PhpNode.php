<?php

namespace PhpTemplates\Dom;

use PhpTemplates\Config;
// todo, move this
class PhpNode extends DomNode
{ 
    public function __toString()
    {
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        $isLoop = in_array($this->nodeName, ['for', 'foreach']); 
        
        if ($this->nodeName && $this->nodeName != '#text' && ($this->nodeValue || $this->nodeValue == '0')) {
            $expr = "{$this->nodeName} ({$this->nodeValue}) {";
        } 
        elseif($this->nodeName && $this->nodeName != '#text') {
            $expr = $this->nodeName . ' {';
        }
        else {
            $expr = $this->nodeValue . ';';
        }
        $return .= '<?php ' . ($isLoop ? '$loopStart(); ' : '') . $expr . ' ?>';
        
        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }
        
        // NODE END
        if ($this->nodeName && $this->nodeName != '#text') {
            $return .= $indentNL . '<?php } ' .($isLoop ? '$loopEnd(); ' : ''). '?>';
        }
        //d($return);
        return $return;
    }
    
    public function getNodeName()
    {
        return '#php-'.$this->nodeName;
    }
}