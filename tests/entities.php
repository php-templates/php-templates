<?php

require('../autoload.php');

use IvoPetkov\HTML5DOMDocument;
//dd(1);
$dom = new HTML5DOMDocument;
$dom->substituteEntities = false;
$dom->loadHtml(file_get_contents('./entities-test.php'));
$dom->querySelector('#elm')
->setAttribute('class', '<?php echo $bar; ?>');
file_put_contents('tmp.php', $dom->saveHtml());