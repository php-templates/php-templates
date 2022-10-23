<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

interface EntityInterface
{
    public function getConfig(): Config;

    public static function test(DomNode $node, EntityInterface $context): bool;
}