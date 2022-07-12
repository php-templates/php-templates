<?php

namespace PhpTemplates;

class DomEvent
{
    private static $events = [];
    private static $cache = [];

    public static function event($ev, $name, $template)
    {
        if (!isset(self::$events[$ev][$name])) {
            return true;
        }
        
        foreach (self::$events[$ev][$name] as $cb) {
            $newNode = $cb($template);
            if ($newNode) {
                $template = $newNode; //TODO: documentat
            }
        }
    }

    public function __construct($ev, $name, $cb)
    {
        self::$events[$ev][$name][] = $cb;
    }
    
    public static function on($ev, $name, $cb)
    {
        if ($ev != 'parsing') return;
        //d($cb);
        self::$events[$ev][$name][] = $cb;
    }
}