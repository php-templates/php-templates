<?php

require('./../autoload.php');

use PhpTemplates\Template;

$t = new Template(__DIR__.'/views/', __DIR__.'/results/');

$t->load('document-scoped-scripts');