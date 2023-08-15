<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\Scope;
use PhpTemplates\Config;
use PhpTemplates\Slot;
use PhpTemplates\EventDispatcher;

/**
 * This is a view resource class, the renderable return of parse process
 */
class View
{
    protected array $props = [];
    protected $__config = 'default';
    
    private $line = null;
    private Scope $shared;
    private Scope $scope;
    private Config $config;
    private EventDispatcher $event;
    private array $attrs = [];
 
    /** trick the anonymous class to not yall about missing params */
    final public static function new(array $data, Scope $shared, Config $config, EventDispatcher $event) 
    {
        return new static($data, $shared, $config, $event);
    } 
    
    final public function __construct(array $data, Scope $shared, Config $config, EventDispatcher $event)
    {
        foreach ($data as $k => $val) {
            if (! array_key_exists($k, $this->props)) {
                $this->attrs[$k] = $data[$k];
            }
        }
        
        $data = array_merge($this->props, (array)$this->data($data));
        
        $this->shared = $shared;
        $this->scope = $shared->innerScope($data);
        $this->config = $config->find($this->__config);
        $this->event = $event;
    }
    
    /**
     * Ment to be overriden in new class {}
     */
    public function data($data): array
    {
        return $data;
    }
    
    /**
     * Array of closures keyed by slot position
     */
    private array $slots = [];

    public array $comp; // used in component build in order to not poluate variables, like this: this->comp[id]

    final public function render() 
    {
        $this->event->trigger('rendering', $this->__name, $this);
        $this->template();
        unset($this->comp);
    }
    
    final public function renderSlots(string $pos, $data)
    {
        foreach ($this->slots($pos) as $slot) {
            $slot->render($data);
        }
    }

    final public function setScope(Scope $scope) 
    {
        $this->scope = $scope;
        
        return $this;
    }
    
    /**
     * Add slot closure to given position
     */
    final public function addSlot(string $pos, $slot, $parent = null): self
    {
        if ($slot instanceof \Closure) {
            $slot = new Slot($parent ?? $this, $slot);
        }
        
        $this->slots[$pos][] = $slot;

        return $this;
    }

    /**
     * Returns closures array for slot located at given position
     *
     * @param  $pos
     * @return array
     */
    final public function slots(string $pos = null): array
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
    final public function setSlots(array $slots): self
    {
        $this->slots = $slots;

        return $this;
    }
    
    public function make(string $class, array $data) 
    {
        return $class::new($data, $this->shared, $this->config, $this->event);
    }
    
    // called when slot in slot
    final public function setSlot($pos, $slots): self
    {
        $this->slots[$pos] = (array)$slots;

        return $this;
    }
    
    final public function __toString(): string
    {
        ob_start();
        $this->render();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
    final public function __call($m, $args) 
    {
        $name = $m;
        $cfg = $this->config;
        // todo if in private this methods and public function addMethod on rendering
        
        if ($m = $cfg->helper($m)) {
            # bind this context to args list
            array_unshift($args, $this);
            return call_user_func_array($m, $args);
        }
        
        throw new \Exception("Helper function $name not found");
    }
    
    final public function attrs($key = null) {
        if ($key) {
            return $this->attrs[$key] ?? null;
        }
        
        return $this->attrs;
    }
    
    final public function __get($prop) 
    {
        return $this->{$prop};
    }
    
    final public function __loopStart() {
        $this->scope = $this->scope->innerScope();
    }
    
    final public function __loopEnd() {
        $this->scope = $this->scope->outerScope();
    }
   
    final public function cfgKey() 
    {
        return $this->config->getName();
    }
    
    final public function __e($string) 
    {
        if ($string && !is_string($string)) {
            $string = json_encode($string);
        }
        echo htmlentities((string)$string);        
    }
    
    final public function __eBind($array, array $except = [])
    {
        $array = array_diff_key((array)$array, array_flip($except));
        $result = [];
        foreach ($array as $k => $val) {
            if (is_bool($val)) {
                if ($val) {
                    $result[] = $k;
                }
                continue;
            }
            
            $val = !is_string($val) ? json_encode($val) : $val;
            if (strlen(trim($val))) {
                $result[] = $k . '="' . htmlentities($val) . '"';
            }
            elseif ($k) {
                $result[] = $k;
            }
        }
        
        echo implode(' ', $result);
    }
        
    final public function __resolveClass(array $class) 
    {
        $result = [];
        foreach ($class as $k => $val) {
            if (is_numeric($k)) {
                // class="[foo ? bar : '']"
                if ($val) {
                    $result[] = $val;
                }
            }
            elseif ($val) {
                // class="[foo => true]"
                $result[] = $k;
            }
        }
        
        return implode(' ', $result);
    }
   
    final public function __arrExcept(array $arr, $except) {
        foreach ((array)$except as $except) {
            unset($arr[$except]);
        }
        
        return $arr;
    }
}