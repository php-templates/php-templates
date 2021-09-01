<?php

require('src/Parser.php');

use PhpTemplates\Parser;
header("Content-Type: text/plain");
$parser = new Parser;
$doc = 'simple';
echo $parser->parse($doc);