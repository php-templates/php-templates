<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

function dd(...$data) {
    foreach ($data as $d) {
        echo '<pre>'.json_encode($data, JSON_PRETTY_PRINT).'</pre>';
    }
    die();
}

require('autoload.php');

use DomDocument\PhpTemplates\Facades\Template;

header("Content-Type: text/plain");
$doc = 'simple';
echo Template::load($doc, [], [
    'slot1' => Template::component('simple-component')
]);