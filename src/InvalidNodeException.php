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
        $this->line = $node->meta['line'];
    }
}