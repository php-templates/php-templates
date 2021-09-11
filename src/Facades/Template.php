<?php

namespace DomDocument\PhpTemplates\Facades;

use DomDocument\PhpTemplates\Template as PhpTemplate;
use DomDocument\PhpTemplates\Parser;

class Template
{
    private function __construct() {}
    
    public static function getInstance(): PhpTemplate
    {
        return new PhpTemplate();
    }
    
    public static function __callStatic($name, $args)
    {
        return call_user_func_array([self::getInstance(), $name], $args);
    }
    
    public static function component(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $options = (array) self::getInstance()->getOptions();
        return new Parser($rfilepath, $data, $slots, $options);
    }
}