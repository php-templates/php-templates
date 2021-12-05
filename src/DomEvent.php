<?php

namespace DomDocument\PhpTemplates;

class DomEvent
{
    private static $events = [];

    public function event($ev, $name, $result, &$data)
    {
        if (isset(self::$events[$ev][$name])) {
            foreach (self::$events[$ev][$name] as $cb) {
                return $cb($result, $data);
            }
        }
    }

    public static function rendering($name, $cb)
    {
        self::$events['rendering'][$name][] = $cb;
    }
}