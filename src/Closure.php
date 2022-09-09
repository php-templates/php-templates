<?php

namespace PhpTemplates;

use Closure as BaseClosure;
use Exception;
use PhpTemplates\Source;

class Closure
{
    private $closure;
    private $source;
    
    public function __construct(BaseClosure $closure, Source $source = null)
    {
        $this->closure = $closure;
        $this->source = $source;
    }
    
    public function __invoke($args) 
    {
        try {
            return call_user_func($this->closure, $args);
        } catch(\Throwable $e) {
            dd($e);
            $e->setMessage($e->getMessage() . "\n" . $this->source);
            throw($e);
        }
    }
    
    public static function fromSource(Source $fnsrc, string $header = '') 
    {
        //d('=>=>'.$fnsrc);
        //register_shutdown_function(function() use ($fnsrc) {
           // echo $fnsrc;
        //});
        try {
            eval("$header \$fn = $fnsrc;");
        } catch(\Throwable $e) {
            dd($e->getMessage()."\n".$fnsrc);
        }
        return new self($fn, $fnsrc);
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