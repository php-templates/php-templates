<?php

namespace PhpTemplates\Parsed;

use PhpTemplates\Scopes\Scope;
use Closure;

class Slot
{
    /**
     * Data passed to component using node attributes
     *
     * @var Scope todo
     */
    private $parent;
    public $scope;
    public $comp = [];

    /**
     * render function to be called
     * @var Closure
     */
    protected $render;

    public function __construct($view, Closure $render)
    {
        $this->parent = $view;
        $this->scope = $view->scope->innerScope();
        $this->render = $render;
    }

    /**
     * Render the template
     *
     * @return void
     */
    public function render(array $data)
    {
        $func = Closure::bind($this->render, $this);
        $func($data);
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
    
    final public function __loopStart() {
        $this->scope = $this->scope->innerScope();
    }
    
    final public function __loopEnd() {
        $this->scope = $this->scope->outerScope();
    }
}