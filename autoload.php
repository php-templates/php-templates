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
    //if (empty($_GET['debug'])) return;
    
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

require_once(__DIR__.'/html5-dom-document-php/autoload.php');

spl_autoload_register(function ($class) {
    $class = trim($class, '\\');
    $path = 'DomDocument\\PhpTemplates\\';
    if (strpos($class, $path) === 0) {
        $class = str_replace($path, '', $class);
        $file = __DIR__.'/src/'.$class.'.php';
        if (file_exists($file)) {
            require_once($file);
        }
    }
});