<?php

namespace PhpTemplates;

use PhpDom\Contracts\DomElementInterface as DomElement;

class ProxyNode
{
    private $name;
    private $node;
    private $obj;
    
    public function __construct(DomElement $node, $obj, string $name) 
    {
        $this->name = $name;
        $this->node = $node;
        $this->obj = $obj;
    }
    
    public function __call($m, $args) 
    {
        $helper = 'node' . ucfirst($m);
        if (method_exists($this->obj, $helper)) {
            array_unshift($args, $this->node);
            return call_user_func_array([$this->obj, $helper], $args);
        }
        elseif (method_exists($this->node, $m)) {
            return call_user_func_array([$this->node, $m], $args);
        }
        
        throw new \Exception("Node function $m does not exist on template {$this->name}");
    }
}