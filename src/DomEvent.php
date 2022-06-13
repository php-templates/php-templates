<?php

namespace PhpTemplates;

class DomEvent
{
    private static $events = [];
    private static $cache = [];

    public static function event($ev, $name, $template)
    {
        if (!isset(self::$events[$ev])) {
            return true;
        }
        
        foreach (self::$events[$ev] as $cb) {
            $cb($template);
        }
    }

    public function __construct($ev, $name, $cb)
    {
        self::$events[$ev][$name][] = $cb;
    }
    
    public static function on($ev, $name, $cb)
    {
        self::$events[$ev][$name][] = $cb;
    }
}