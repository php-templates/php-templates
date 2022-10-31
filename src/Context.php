<?php

namespace PhpTemplates;

class Context
{
    public $parent;
    public $loopContext;
    private $loopDepth = 0;
    private $data;

    public function __construct(array $data = [], self $parent = null)
    {
        $this->data = $data ?? [];
        $this->parent = $parent;
        
        if ($parent) {
            $this->data['_attrs'] = &$parent->_attrs;
        }
        elseif (!isset($this->data['_attrs'])) {
            $this->data['_attrs'] = [];
        }
    }

    public function &__get($prop)
    {
        if ($this->loopContext) {
            return $this->loopContext->get($prop);
        }

        return $this->get($prop);
    }

    public function __set($prop, $val)
    {
        if ($this->loopContext) {
            $this->loopContext->$prop = $val;
        } else {
            $this->data[$prop] = $val;
        }
    }

    public function __isset($prop)
    {
        return !is_null($this->get($prop));
    }

    public function merge(array ...$data)
    {
        array_unshift($data, $this->data);
        $this->data = call_user_func_array('array_merge', $data);
    }

    public function leaseMerge(array $data)
    {
        $this->data = array_merge($data, $this->data);
    }

    public function subcontext(array $data = [])
    {
        if ($this->loopContext) {
            return new Context($data, $this->loopContext);
        }

        return new Context($data, $this);
    }

    public function loopStart()
    {
        if ($this->loopDepth <= 0) {
            $this->loopContext = $this->subcontext();
        }
        $this->loopDepth++;
    }

    public function loopEnd()
    {
        $this->loopDepth--;
        if ($this->loopDepth <= 0) {
            $this->loopContext = null;
        }
    }

    public function has(string $prop)
    {
        return array_key_exists($prop, $this->data);
    }

    public function &get($prop)
    {
        if ($prop == '_context') {
            return $this;
        }
        if ($prop == '_attrs') {
            return $this->data['_attrs'];
        }
        if ($prop == '_data') {
            return $this->data;
        }

        if (array_key_exists($prop, $this->data)) {
            return $this->data[$prop];
        } elseif (isset($this->data['_attrs']) && array_key_exists($prop, $this->data['_attrs'])) {
            return $this->data['_attrs'][$prop];
        } elseif ($this->parent) {
            return $this->parent->get($prop);
        }

        $this->data[$prop] = null;
        if ($prop == '_attrs') {
            $this->data['_attrs'] = [];
        }

        return $this->data[$prop];
    }

    public function all()
    {
        return $this->data;
    }
}
