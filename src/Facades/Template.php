<?php

namespace HarmonyTools\Facades;

class Template
{
    private function __construct() {}
    
    public static function gétInstance(): \HarmonyTools\PhpTemplates
    {
        return new \HarmonyTools\PhpTemplates();
    }
    
    public static function __callStatic($name, $args)
    {
        return call_user_func([self::getInstance(), $args]);
    }
}