<?php

// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

function dd(...$data) {
    foreach ($data as $d) {
        //var_dump($d);
        //echo '<pre>';
        print_r($d);
        //echo '</pre>';
    }
    die();
}

require('autoload.php');

use DomDocument\PhpTemplates\Facades\Template;

header("Content-Type: text/plain");
$doc = 'simple';
echo Template::load($doc, ['rootData' => 123], [
    'slot1' => Template::component('simple-component', ['s1' => 123])
]);