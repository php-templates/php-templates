<?php

 error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

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

function dom($d, $name = '', $depth = 0)
{
    if (empty($_GET['debug'])) return;
    $x = debug_backtrace();
    if (is_string($d)) {
        $content = $d;
    } else {
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
    }
    //print_r($x[0]['file'].'->'.$x[0]['line']);


    echo '<div style="padding-left:'.($depth*0).'px"><div style="background:#f4ff9a; border: 1px solid black; margin-bottom:10px; padding:5px;">';
    echo '<div><b>'. $name .'</b></div>';
    echo htmlspecialchars($content);
    echo '</div></div>';
}   

function buf($self, $name = '', $depth = 0)
{
    if (empty($_GET['debug'])) return;
    echo '<div style="padding-left:'.($depth*0).'px"><div style="background:#e6e6e6; border: 1px solid black; margin-bottom:10px; padding:5px;">';
    echo '<div><b>'. $name .'</b></div>';
    echo htmlspecialchars($self->codebuffer->getStream());
    echo '</div></div>';
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
$doc = $_GET['file'] ?? 'test';

Config::set('aliased', [
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
]);

$data['entry_firstname'] = 'Prenume';
$data['firstname'] = 'Florin';
$data['entry_lastname'] = 'Nume';
$data['lastname'] = 'Botea';
$data['entry_gender'] = 'Sex';
$data['entry_email'] = 'Email';
$data['email'] = 'florin@email.com';
$data['gender'] = 'male';
$data['entry_male'] = 'Masculin';
$data['entry_female'] = 'Feminin';

echo Template::load($doc, $data);
die();



echo Template::load($doc, $data, [
    'slot1' => Template::component('simple-component', ['s1' => 123]),
    'slot-array' => [
        Template::component('simple-component'),
        Template::component('simple-component', ['s1' => 123]),
    ]
]);