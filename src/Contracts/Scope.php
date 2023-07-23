<?php

namespace PhpTemplates\Contracts;
// todo comments
interface Scope
{
    public function merge(array $data);
    
    public function innerScope(array $data = []);
        
    public function has(string $prop);
    
    public function &get($prop, $safe = true);
}