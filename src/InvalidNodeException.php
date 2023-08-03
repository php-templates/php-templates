<?php

namespace PhpTemplates;

class InvalidNodeException extends \Exception 
{
    protected $code = 0;  
    protected $file;  
    
    public function __construct($msg, $node)
    {
        parent::__construct($msg);
        $this->file = (string)$node->meta['file'];
        $this->line = $this->_getLine($node);
    }
    
    private function _getLine($node) 
    {
        if ($node->getLine()) {
            return $node->getLine();
        }
        
        $refNode = $node;// todo prevsibling too=
        while ($refNode->getParentNode()) {
            $refNode = $refNode->getParentNode();
            if ($refNode instanceof \PhpDom\DomNode && $refNode->getLine()) {
                return $refNode->getLine();
            }
        }
    }
}