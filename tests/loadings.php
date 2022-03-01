<?php

require('../autoload.php');

use IvoPetkov\HTML5DOMDocument;
//dd(1);
$dom = new HTML5DOMDocument;
$dom->loadHtml(file_get_contents('./entities-test.php'));
$fragment = $dom->createDocumentFragment();
dd(get_class_methods($dom));
$fragment->appendXML(file_get_contents('./components/form-group.template.php'));
echo $dom->saveHtml();