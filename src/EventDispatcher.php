<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher as EventDispatcherInterface;
use PhpTemplates\TemplateClassDefinition;
use PhpDom\Contracts\DomElementInterface as DomElement;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * [event_time][template_name][][callback($payload)]
     */
    private $events = [];

    /**
     * Trigger Event
     */
    public function trigger(string $ev, string $name, ...$payload)
    {
        if (!isset($this->events[$ev])) {
            return true;
        }

        $listeners = [];
        foreach ($this->events[$ev] ?? [] as $group => $events) {
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
                        // classes with __invoke method may be provided as callback
                        if (is_string($listener['fn'])) {
                            $listener['fn'] = new $listener['fn'];
                        }
                        $listeners[] = $listener;
                    }
                }
            }
        }

        usort($listeners, function($a, $b) {
            return $b['weight'] - $a['weight'];
        });

        foreach ($listeners as $listener) {
            call_user_func_array($listener['fn'], $payload);
        }
    }

    /**
     * Add event listener to given process, 
     * an array may be given for param name
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
    
    /**
     * Add event listener to given process, with execution only once
     * an array may be given for param name
     */
    public function once(string $ev, $name, callable $cb, $weight = 0)
    {
        foreach ((array)$name as $name) {
            $k = explode('*', $name)[0];
            $i = count($this->events[$ev][$k] ?? []);
            $callback = function() use ($cb, $i, $ev, $k) {
                unset($this->events[$ev][$k][$i]);
                call_user_func_array($cb, func_get_args());
            };
            
            $this->events[$ev][$k][] = [
                'name' => $name,
                'fn' => $callback,
                'weight' => $weight
            ];
        }
    }
    
    /**
     * Event on parsing template, most used
     */
    public function parsing($name, callable $cb, $weight = 0) 
    {
        $this->on('parsing', $name, $cb, $weight);
    }
    
    /**
     * Event on parsed template
     */
    public function parsed($name, callable $cb, $weight = 0) 
    {
        $this->on('parsed', $name, $cb, $weight);
    }
    
    /**
     * Event on rendering template, most used
     */
    public function rendering($name, callable $cb, $weight = 0) 
    {
        $this->on('rendering', $name, $cb, $weight);
    }
}