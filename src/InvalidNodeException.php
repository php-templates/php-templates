<?php

namespace PhpTemplates;

class InvalidNodeException extends \Exception 
{
    protected $code = 0;                        // user defined exception code
    protected $file;  
    
    public function __construct($msg, $node)
    {
        parent::__construct($msg);//$node->dd();
        $this->file = $node->srcFile;
        $this->line = $node->lineNumber;
    }
}