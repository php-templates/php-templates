<?php

namespace PhpTemplates\Contracts;

interface Context
{
    public function merge(array $data);
    
    public function subcontext(array $data = []);
        
    public function has(string $prop);
    
    public function &get($prop, $safe = true);
}