<?php

namespace PhpTemplates;

use Closure as BaseClosure;
use Exception;
use PhpTemplates\Source;
// todo remove this class
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
    }

    public static function fromSource(Source $fnsrc)
    {
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