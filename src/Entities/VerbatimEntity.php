<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\ViewParser;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\Source;
use PhpTemplates\Dom\Parser;

class VerbatimEntity implements EntityInterface
{
    const WEIGHT = 1000;
    
    public static function test(DomNode $node, EntityInterface $context)
    {
        return $node->hasAttribute('verbatim');
    }
    
    public function componentContext() {}
    public function slotContext() {}
    public function simpleNodeContext() {}
    public function anonymousContext() {}
    
    public function getConfig() {
        return null;
    }
}