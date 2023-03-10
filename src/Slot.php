<?php

namespace PhpTemplates;

use Closure;

class Slot
{
    /**
     * Data passed to component using node attributes
     *
     * @var Context
     */
    private $parent;
    public $context;
    public $comp = [];

    /**
     * render function to be called
     * @var Closure
     */
    protected $render;

    public function __construct($view, Closure $render)
    {
        $this->parent = $view;
        $this->context = $view->context;
        $this->render = $render;
    }

    /**
     * Render the template
     *
     * @return void
     */
    public function render(array $data)
    {
        $this->context = $this->context->subcontext(['slot' => new Context($data)]);// todo: use existing
        $func = Closure::bind($this->render, $this);
        $func();
    }
    
    public function slots(string $pos = null) 
    {
        return $this->parent->slots($pos);
    }

    public function __get($prop) 
    {
        return $this->parent->$prop;
    }
    
    public function __call($m, $args) 
    {
        return call_user_func_array([$this->parent, $m], $args);
    }
}