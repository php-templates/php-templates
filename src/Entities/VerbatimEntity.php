<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;

class VerbatimEntity extends AbstractEntity
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
    
    public function extendContext()
    {
    }
    
    public function textNodeContext()
    {
    }

    public function getConfig(): Config
    {
        return new Config('', '');
    }
}
