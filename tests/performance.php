<?php

require('../autoload.php');

use PhpTemplates\Config;
use PhpTemplates\ConfigHolder;
use PhpTemplates\DependenciesMap;
use PhpTemplates\EventHolder;
use PhpTemplates\ViewParser;
use PhpTemplates\Template;
use PhpTemplates\View;
use PhpTemplates\PhpTemplate;
use PhpTemplates\Document;
use PhpTemplates\Process;
use PhpTemplates\TemplateFunction;
use PhpTemplates\Dom\DomNodeAttr;
use PhpTemplates\Dom\DomNode;

//header("Content-Type: text/plain");

$cfg = new Config('default', __DIR__);
//$dependenciesMap = new DependenciesMap('./dep.php', __DIR__.'/results/');
$eventHolder = new EventHolder();
$viewFactory = new Template(__DIR__.'/results', $cfg, $eventHolder);
//$cfgHolder = $viewFactory->getConfig();
