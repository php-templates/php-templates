<?php

// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

function dd(...$data) {
    //print_r(debug_backtrace());
    foreach ($data as $d) {
        //var_dump($d);
        //echo '<pre>';
        print_r($d);
        //echo '</pre>';
    }
    die();
}

function d(...$data) {
    $x = debug_backtrace();
    //print_r($x[0]['file'].'->'.$x[0]['line']);
    foreach ($data as $d) {
        //var_dump($d);
        //echo '<pre>';
        print_r($d);
        //echo '</pre>';
        echo PHP_EOL;
    } 
}

    function dom($d)
    {
        $x = debug_backtrace();
        //print_r($x[0]['file'].'->'.$x[0]['line']);
        if (!is_iterable($d)) {
            $d = [$d];
        }
        $content = '';
        foreach ($d as $node)
        {
            if (@$node->ownerDocument) {
            //$node = $dom->importNode($node, true);
                $content.= $node->ownerDocument->saveHtml($node);
            }
            else {
                $content.= $node->saveHtml();
            }
        }
        echo $content;
        echo '
        ---
        ';
    }

function dif($if, ...$data) {
    if (!$if) {
        return;
    }
    foreach ($data as $d) {
        //var_dump($d);
        //echo '<pre>';
        print_r($d);
        //echo '</pre>';
    } 
}

require('autoload.php');

use DomDocument\PhpTemplates\Facades\Template;
use DomDocument\PhpTemplates\Facades\Config;

if ($_GET['plain'] ?? false) {
header("Content-Type: text/plain");
}
$doc = 'test';

Config::set('aliased', [
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
]);

echo Template::load($doc);
die();

echo Template::load($doc, ['rootData' => 123], [
    'slot1' => Template::component('simple-component', ['s1' => 123]),
    'slot-array' => [
        Template::component('simple-component'),
        Template::component('simple-component', ['s1' => 123]),
    ]
]);