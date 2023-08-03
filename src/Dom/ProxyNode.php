<?php
namespace PhpTemplates\Dom;

use PhpDom\Contracts\DomNodeInterface as DomNode;

class ProxyNode 
{
    private DomNode $node;
    
    public function __construct(DomNode $node) 
    {
        $this->node = $node;
    }
    
    public function __call($m, $args) 
    {// todo proxy
        return call_user_func_array([$this->node, $m], $args);
    }
    
    public function __get(string $prop) 
    {// todo proxy
        return $this->node->$prop;
    }
}