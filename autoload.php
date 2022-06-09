<?php

error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

if (!function_exists('dd')) {
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

function dom($dom)
{
    echo PHP_EOL.'-------------'.PHP_EOL.$dom.PHP_EOL.'-------------'.PHP_EOL;
    die();
}   

function buf($self, $name = '', $depth = 0)
{
    if (empty($_GET['debug'])) return;
    echo '<div style="padding-left:'.($depth*0).'px"><div style="background:#e6e6e6; border: 1px solid black; margin-bottom:10px; padding:5px;">';
    echo '<div><b>'. $name .'</b></div>';
    echo htmlspecialchars($self->codebuffer->getStream());
    echo '</div></div>';
}

require_once('vendor/autoload.php');
require_once(__DIR__.'/src/helpers.php');
spl_autoload_register(function ($class) {
    $class = trim($class, '\\');
    $path = 'PhpTemplates\\';
    if (strpos($class, $path) === 0) {
        $class = str_replace($path, '', $class);
        $file = __DIR__.'/src/'.$class.'.php';
        $file = str_replace('\\', '/', $file);
        if (file_exists($file)) {
            require_once($file);
        }
    }
});