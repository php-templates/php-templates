<?php

namespace PhpTemplates;

interface ContextInterface
{
    public function merge(array $data);
    
    public function subcontext(array $data = []);
        
    public function has(string $prop);
    
    public function &get($prop, $safe = true);
}