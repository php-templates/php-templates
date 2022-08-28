<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\DomNode;

interface EntityInterface
{
    public function getConfig();
    public static function test(DomNode $node, EntityInterface $context); 
    
}