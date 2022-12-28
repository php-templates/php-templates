<?php

namespace PhpTemplates\Dom;

/**
 * @see DomNode
 */
class ResultQuery // in v2
{
    private $nodes = [];
    
    public $nodeName = '#resultQuery';
    
    public function __construct(array $nodes) {
        $this->nodes = $nodes;
    }
    
    public function __call($m, $args) {
        foreach ($this->nodes as $node) {
            call_user_func_array([$node, $m], $args);
        }
        return $this;
    }
    
    public function __get($prop) {
        $m = 'get' . ucfirst($prop);
        if (method_exists($this, $m)) {
            return $this->$m();
        }
        
        return $this->$prop;
    }
    
    public function count() {
        return count($this->nodes);
    }
    
    public function first() {
        return reset($this->nodes);
    }

    public function last() {
        return end($this->nodes);
    }
    
    public function item($i) {
        return $this->nodes[$i] ?? null;
    }
    
    public function getChildNodes() {
        $nodes = [];
        foreach ($this->nodes as $node) {
            foreach ($node->childNodes as $cn) {
                $nodes[] = $cn;
            }
        }
        
        return $nodes;
    }
    
    public function __toString() {
        return implode('', $this->nodes);
    }
}