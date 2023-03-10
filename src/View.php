<?php
//todo: add public props and attrs, function setprops
namespace PhpTemplates;

use Closure;
use PhpTemplates\Closure as PhpTemplatesClosure;

/**
 * This is a view resource class, the renderable return of parse process
 */
abstract class View
{
    /** 
     * Called template function name
     * @var string
     */
    protected static $name;
    
    /**
     * Data passed to component using node attributes
     *
     * @var Context
     */
    public $context;
    
    protected $registry;

    /**
     * Array of closures keyed by slot position
     * @var array
     */
    public $slots = [];

    //public $slot; // legacy used in loops to not poluate variables, like this: foreach this->slots as this->slot
    public $comp; // used in component build in order to not poluate variables, like this: this->comp[id] =

    public function __construct(Registry $registry, $data)
    {
        $this->registry = $registry;
// todo: compose data here        
        if (is_array($data)) {
            $this->context = $registry->shared->subcontext($this->data($data));
        } else {
            // context given, aka extends
            $this->context = $data;
        }
        
        $registry->event->event('rendering', static::name, $this);
    }

    /**
     * Render the template
     *
     * @return void
     */
     public function render() {}

    /**
     * Set data to template
     *
     * @param array $data
     * @return self
     */
    public function with(array $data = []): self
    {
        if (!$this->context) {
            $this->context = new Context($data);
        } else {
            $this->context->merge($data);
        }

        return $this;
    }

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

    /**
     * Instantiate a new template from cache, within given context
     *
     * @param string $name
     * @param Context|null $context
     * @return self
     */
    public function template(string $name, Context $context = null): self
    {
        return $this->store->get($name, $context);
    }
    
    public function __toString() 
    {
        ob_start();
        $this->render();
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    }
    
    public function __get($prop) 
    {
        return $this->$prop ?? $this->registry->$prop ?? null;
    }
    
    protected function data($data) 
    {
        return $data;
    }
    
    public function getConfig() 
    {
        return $this->registry->config->find($this->cfgKey());
    }
    
    public function cfgKey() 
    {
        return static::config;
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