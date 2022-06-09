<?php

namespace PhpTemplates\Dom;

class PhpNode extends DomNode
{/*
    protected $nodeName;
    protected $nodeValue;
    protected $node;
    
    public function __construct(string $nodeName, string $nodeValue = '')
    {
        $this->nodeName = trim($nodeName);
        $this->nodeValue = $nodeValue;
    }
    */
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
  /*  
    public function __get($prop)
    {
        return $this->node->{$prop};
    }
    
    public function __call($m, $args)
    {
        return call_user_func([$this->node, $m], $args);
    }*/
}