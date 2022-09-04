<?php

namespace PhpTemplates;

use Closure as BaseClosure;
use PhpTemplates\Dom\Source;

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
        } catch(Exception $e)
        {
            $e->setMessage($e->getMessage() . "\n" . $this->source);
            throw($e);
        }
    }
    
    public static function fromSource(Source $fnsrc, string $header = '') 
    {
        eval("$header \$fn = $fnsrc;");
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