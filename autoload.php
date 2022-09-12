<?php


error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

if (!function_exists('dd')) {
    function dd(...$data) {
        //debug_print_backtrace(2);die();
        foreach ($data as $d) {
            //var_dump($d);
            echo '<pre>';
            print_r($d);
            echo '</pre>';
        }
        exit();
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

//file_put_contents(sys_get_temp_dir().'/foo.php', '');
//require(sys_get_temp_dir().'/foo.php');
//dd(glob(sys_get_temp_dir().'/*'));

function xd($data) {
    $x = debug_backtrace();
    //print_r($x[0]['file'].'->'.$x[0]['line']);
    //foreach ($data as $d) {
    //var_dump($d);
    //echo '<pre>';
    print_r('--' . ($data ?? 'null'));
    //echo '</pre>';
    echo PHP_EOL;
    return $data;
    //}
}


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