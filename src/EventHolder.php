<?php

namespace PhpTemplates;

class EventHolder
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

    public static function on($ev, $name, $cb)
    {
        if ($ev != 'parsing') return;
        //d($cb);
        self::$events[$ev][$name][] = $cb;
    }
}