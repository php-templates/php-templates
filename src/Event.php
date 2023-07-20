<?php

namespace PhpTemplates;

class Event 
{
    private static ?EventDispatcher $event = null;
    
    private function __construct() {}
    
    public static function boot(EventDispatcher $event)
    {
        if (!empty(self::$event)) {
            return;
        }
        
        self::$event = $event;
    }
    
    public static function __callStatic($m, $args)
    {
        return call_user_func_array([self::$event, $m], $args);
    }
}