<?php

namespace DomDocument\PhpTemplates\Facades;

use DomDocument\PhpTemplates\Template as PhpTemplate;

class Template
{
    private function __construct() {}
    
    public static function getInstance(): PhpTemplate
    {
        return new PhpTemplate();
    }
    
    public static function __callStatic($name, $args)
    {
        return call_user_func([self::getInstance(), $args]);
    }
}