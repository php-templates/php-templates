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

if ($_GET['plain'] ?? false) {
header("Content-Type: text/plain");
}
$doc = 'simple';
//$doc = 'test-nested-component';
//$x = (new IvoPetkov\HTML5DOMDocument);
//$x->loadHtml(file_get_contents('views/component-1.template.php'));
//dd($x->getElementsByTagName('body')->item(0)->childNodes);
echo Template::load('test');
die();

echo Template::load($doc, ['rootData' => 123], [
    'slot1' => Template::component('simple-component', ['s1' => 123]),
    'slot-array' => [
        Template::component('simple-component'),
        Template::component('simple-component', ['s1' => 123]),
    ],
    'slot-nested' => Template::component('simple-component', [], [
        'default' => Template::component('simple-component', ['s1' => 123]),
    ]),
    'slot-array-nested' => Template::component('simple-component', ['foo' => 124], [
        'default' => [
            Template::component('simple-component', ['s1' => 123]),
            Template::component('simple-component', [], [
                'default' => [
                    Template::component('simple-component'),
                    Template::component('simple-component', ['s1' => 123]),
                ]
            ]),
        ]
    ]),
]);