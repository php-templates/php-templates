<?php

require('./../autoload.php');

use PhpTemplates\PhpTemplate;

$t = new PhpTemplate(__DIR__.'/views/', __DIR__.'/results/');

$t->load('document-scoped-scripts');