<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher as EventDispatcherInterface;
use PhpTemplates\Dom\DomNode;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * [event_time][template_name][][callback($payload)]
     */
    private $events = [];

    /**
     * Trigger Event
     *
     * @param string $ev - parsing, parsed or rendering
     * @param string $name - template name
     * @param DomNode $template - template instance
     * @return void
     */
    public function trigger(string $ev, string $name, $template) {
        $this->event($ev, $name, $template);
    }
    
    public function event(string $ev, string $name, $template)
    {
        if (!isset($this->events[$ev])) {
            return true;
        }

        $listeners = [];
        foreach ($this->events[$ev] as $group => $events) {
            if (strpos($name, $group) !== 0) {
                continue;
            }
            if ($group == $name) {
                $listeners = $events;
            }

            foreach ($events as $listener) {
                if (strpos($listener['name'], '*')) {
                    $regex = '/' . str_replace(['\*'], ['((?!\/).)*'], preg_quote($listener['name'], '/')) . '/';

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
    public function on(string $ev, $name, callable $cb, $weight = 0)
    {
        foreach ((array)$name as $name) {
            $k = explode('*', $name)[0];
            $this->events[$ev][$k][] = [
                'name' => $name,
                'fn' => $cb,
                'weight' => $weight
            ];
        }
    }
}