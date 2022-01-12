<?php

namespace DomDocument\PhpTemplates;

class DomEvent
{
    private static $events = [];
    private static $cache = [];

    public static function event($ev, $name, $template, &$data)
    {
        if (!isset(self::$events[$ev])) {
            return true;
        }
        
        if (!isset(self::$cache[$ev][$name])) {
            $eventParts = explode('.', $name);
            foreach (self::$events[$ev] as $k => $x) {
                $listenerParts = explode('.', $k);
                $_eventParts = array_intersect($listenerParts, $eventParts);
                if (end($eventParts) === end($listenerParts) && implode('.', $_eventParts) === $k) {
                    //d(implode('.', $_eventParts), $k);
                    self::$cache[$ev][$name][] = $k;
                }
            }
        }
        //if ($name !== 'user-profile-form')dd(self::$cache);
        $continueExecution = true;
        if (isset(self::$cache[$ev][$name])) {
            foreach (self::$cache[$ev][$name] as $n) {
                foreach (self::$events[$ev][$n] as $cb) {
                    $continueExecution = $continueExecution && $cb($template, $data) !== false; // cb should always return false if stop execution is required
                }
            }
        }

        return $continueExecution;
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