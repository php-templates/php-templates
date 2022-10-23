<?php

namespace PhpTemplates;

class EventHolder
{
    private static $events = [];
    private static $cache = [];

    /**
     * Trigger Event
     *
     * @param string $ev - parsing, parsed or rendering
     * @param string $name - template name
     * @param [type] $template - template instance
     * @return void
     */
    public function event(string $ev, string $name, $template)
    {
        //d('event ' . $ev . ' ' . $name);
        if (!isset(self::$events[$ev])) {
            return true;
        }

        $listeners = [];
        foreach (self::$events[$ev] as $group => $events) {
            if (strpos($name, $group) !== 0) {
                continue;
            }
            if ($group == $name) {
                $listeners = $events;
            }

            foreach ($events as $listener) {
                if (strpos($listener['name'], '*')) {
                    $regex = '/' . str_replace(['\*'], ['((?!\/).)*'], preg_quote($listener['name'], '/')) . '/';
                    //d($regex, $name);
                    if (preg_match($regex, $name, $m) && $m[0] == $name) {
                        $listeners[] = $listener;
                    }
                }
            }
        }

        usort($listeners, function($a, $b) {
            return $b['weight'] - $a['weight'];
        });

        foreach ($listeners as $listener) {
            $listener['fn']($template);
        }
    }

    /**
     * Add event listener to given process
     *
     * @param string $ev - parsing, parsed or rendering
     * @param string $name - template name
     * @param callable $cb - listener / event callback
     * @param integer $weight - weighter callbacks are executed first
     * @return void
     */
    public function on(string $ev, string $name, callable $cb, $weight = 0)
    {
        $k = explode('*', $name)[0];
        self::$events[$ev][$k][] = [
            'name' => $name,
            'fn' => $cb,
            'weight' => $weight
        ];
    }
}