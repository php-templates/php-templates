<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;

class VerbatimEntity implements AbstractEntity
{
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
