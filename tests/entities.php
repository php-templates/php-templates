<?php

require('../autoload.php');

use IvoPetkov\HTML5DOMDocument;
//dd(1);
$dom = new HTML5DOMDocument;
$dom->loadHtml(file_get_contents('./entities-test.php'));
echo $dom->saveHtml();