<?php

namespace DomDocument\PhpTemplates;

class DomEvent
{
    private static $events = [];

    public function event($ev, $name, $template, &$data)
    {
        $continueExecution = true;
        if (isset(self::$events[$ev][$name])) {
            foreach (self::$events[$ev][$name] as $cb) {
                $continueExecution = $continueExecution && $cb($template, $data) !== false; // cb should always return false if stop execution is required
            }
        }

        return $continueExecution;
    }

    public function __construct($ev, $name, $cb)
    {
        self::$events[$ev][$name][] = $cb;
    }
}