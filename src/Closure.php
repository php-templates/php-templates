<?php

namespace PhpTemplates;

use Closure as BaseClosure;
use Exception;
use PhpTemplates\Source;

class Closure
{
    private $source;
    
    public function __construct(?BaseClosure $closure, Source $source = null)
    {
        $this->closure = $closure;
        $this->source = $source;
    }
    
    public function __invoke($args) 
    {
        return call_user_func($this->closure, $args);
        try {//todo
        } catch(\Throwable $e) {
            dd(''.$this->source, $e);
            $e->setMessage($e->getMessage() . "\n" . $this->source);
            throw($e);
        }
    }
    
    public static function fromSource(Source $fnsrc) 
    {
        //d('=>=>'.$fnsrc);
        //register_shutdown_function(function() use ($fnsrc) {
           // echo $fnsrc;
        //});
        return new self(null, $fnsrc);
    }
    
    public function bindTo($self) 
    {
        $this->closure = $this->closure->bindTo($self);
        return $this;
    }
    
    public function getFile() 
    {
        return $this->source->getFile();
    }
}