<?php

namespace PhpTemplates\Contracts;

use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Parsed\View;
use PhpTemplates\ParsedTemplate;

interface Entity
{
    public function getConfig(): Config;
    
    public function getDocument(): Document;
   
    // minimal implementation
    public function startupContext();
}
