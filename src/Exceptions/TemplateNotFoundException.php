<?php

namespace PhpTemplates\Exceptions;

class TemplateNotFoundException extends \Exception
{
    private $tried;
    
    public function __construct($msg, array $tried = []) 
    {
        parent::__construct($msg);

        $this->tried = $tried;
    }
    
    public function getTried() 
    {
        return $this->tried;
    }
}