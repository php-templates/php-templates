<?php

require('../autoload.php');

use PhpTemplates\Dom\Parser;
use PhpTemplates\Source;

$file = __DIR__ . '/dom-parser.t.php';
$source = new Source(file_get_contents($file), $file);
$parser = new Parser();
$node = $parser->parse($source);

echo $node;
echo "\n";
dd($node->debug());