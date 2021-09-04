<?php

require('autoload.php');

use DomDocument\PhpTemplates\Facades\Template;

header("Content-Type: text/plain");
$doc = 'simple';
echo Template::load($doc);