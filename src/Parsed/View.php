<?php

namespace PhpTemplates\Parsed;

use PhpTemplates\Context\Context;

/**
 * This is a view resource class, the renderable return of parse process
 */
class View extends Context
{
    /**
     * Array of closures keyed by slot position
     */
    private array $slots = [];

    public array $comp; // used in component build in order to not poluate variables, like this: this->comp[id] =

    /**
     * Add slot closure to given position
     *
     * @param string $pos
     * @param Closure $renderable
     * @return self
     */
    public function addSlot(string $pos, Slot $slot): self
    {
        $this->slots[$pos][] = $slot;

        return $this;
    }

    /**
     * Returns closures array for slot located at given position
     *
     * @param  $pos
     * @return array
     */
    public function slots(string $pos = null): array
    {
        if (!$pos) {
            return $this->slots;
        }
        
        if (isset($this->slots[$pos])) {
            return $this->slots[$pos];
        }
        return [];
    }

    /**
     * Absolutely set all slots array overriding any existing slot
     *
     * @param array $slots
     * @return self
     */
    public function setSlots(array $slots): self
    {
        $this->slots = $slots;

        return $this;
    }
    
    // called when slot in slot
    public function setSlot($pos, $slots): self
    {
        $this->slots[$pos] = (array)$slots;

        return $this;
    }
    
    public function __call($m, $args) 
    {
        $name = $m;
        $cfg = $this->getConfig();
        if ($m = $cfg->helper($m)) {
            array_unshift($args, $this);
            return call_user_func_array($m, $args);
        }
        throw new \Exception(" Helper function $name not found");
    }
}