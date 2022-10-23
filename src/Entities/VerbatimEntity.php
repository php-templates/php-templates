<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

class VerbatimEntity implements EntityInterface
{
    const WEIGHT = 1000;

    public static function test(DomNode $node, EntityInterface $context): bool
    {
        return $node->hasAttribute('verbatim');
    }

    public function templateContext()
    {
    }
    public function slotContext()
    {
    }
    public function simpleNodeContext()
    {
    }
    public function anonymousContext()
    {
    }
    public function verbatimContext()
    {
    }

    public function getConfig(): Config
    {
        return new Config('', '');
    }
}
