<?php

namespace PhpTemplates;

class Registry
{
    private $id;
    
    private static $_id = 1;
    public function __construct() {
        $this->id = self::$_id;
        self::$_id++;
    }
    
    private $props = [
        'uses' => []
    ];
    
    public function &__get($prop) {
        if (!isset($this->props[$prop])) {
            $this->props[$prop] = null;
        }
        return $this->props[$prop];
    }
    
    public function __set($prop, $val) {
        $this->props[$prop] = $val;
    }
}