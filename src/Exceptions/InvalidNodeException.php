<?php

namespace PhpTemplates\Exceptions;

class InvalidNodeException extends \Exception 
{
    public function __construct($msg, $node)
    {
        parent::__construct($msg);

        $this->findReference($node);
    }
    
    private function findReference($node) 
    {
        if ($node->getLine()) {
            $this->line = $node->getLine();
            $this->file = $node->getFile();
            return;
        }
        
        $refNode = $node;
        while ($refNode->getPrevSibling() || $refNode->getParentNode()) {
            $refNode = $refNode->getPrevSibling() ?? $refNode->getParentNode();
            if ($refNode instanceof \PhpDom\DomNode && $refNode->getLine()) {
                $this->line = $refNode->getLine();
                $this->file = $refNode->getFile();
                return;
            }
        }
    }
}