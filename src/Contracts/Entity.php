<?php

namespace PhpTemplates\Contracts;

use PhpTemplates\Config;
use PhpTemplates\Parsed\TemplateFile;
use PhpTemplates\Parsed\View;
use PhpTemplates\ParsedTemplate;

interface Entity
{
    public function getConfig(): Config;
    
    public function getDocument(): TemplateFile;
   
    // minimal implementation
    public function startupContext();
}
