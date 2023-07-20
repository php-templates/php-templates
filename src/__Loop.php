<?php

namespace PhpTemplates;
// legacy
use PhpTemplates\Scopes\LoopScope;

/**
 * This is a scoped loop class, used to scope loops
 */
class Looplegacy
{
    private $parent;
    public $scope;
    private $subject;
    private $i;
    private $key;
    private $value;
    public $comp = []; // for comp init
    
    public function __construct($view, $subject, $value, $key = null) 
    {
        $this->parent = $view;
        $this->key = $key;
        $this->value = $value;
        // lock data
        $data[$value] = null;
        if ($key) {
            $data[$key] = null;
        }
        $data['loop'] = $this;
        $this->scope = new LoopScope($data, $view->scope);
        $this->subject = !is_iterable($subject) ? (array)$subject : $subject;
    }
    
    public function run(\Closure $cb)
    {
        $key = $this->key;
        $value = $this->value;
        $this->i = 0;
        
        $cb = \Closure::bind($cb, $this);
        
        if (!$key) {
            foreach ($this->subject as $this->scope->{$value}) {
                $cb();
                $this->i++;
            }
        }
        else {
            foreach ($this->subject as $this->scope->{$key} => $this->scope->{$value}) {
                $cb();  
                $this->i++;
            }
        }
    }
    
    public function isFirst() 
    {
        return $this->i === 0;
    }
    
    public function isLast() 
    {
        return $this->i === count($this->subject) -1;
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