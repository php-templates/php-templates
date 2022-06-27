<?php

require('../autoload.php');

use PhpTemplates\Config;
use PhpTemplates\Parsed;
use PhpTemplates\Template;
use PhpTemplates\Document;
use PhpTemplates\Process;
use PhpTemplates\TemplateFunction;

header("Content-Type: text/plain");

$parser = new Template(__DIR__, __DIR__.'/results/');
$cfg = $parser->getConfig();
$parser->addAlias('x-form-group', 'components/form-group');
$parser->addAlias('x-input-group', 'components/input-group');
$parser->addAlias('x-card', 'components/card');
$parser->addAlias('x-helper', 'components/helper');

$parser->addPath('cases2', __DIR__.'/cases2/');
$parser->addAlias('x-form-group', 'components/form-group', 'cases2');
$parser->addDirective('mydirective', function() {
    return ['mydirective' => 2];
}, 'cases2');

$parser->addDirective('checked', function($eval) {
    return [
        'p-raw' => $eval.' ? "checked" : ""'
    ];
});


$files = array_diff(scandir('./results'), array('.', '..'));
foreach($files as $file){ // iterate files
    $file = './results/' . $file;
    if(is_file($file)) {
        unlink($file); // delete file
    }
}

$files = scandir('./cases');
$files = array_diff($files, ['.', '..', './']);

foreach($files as $f) {
    if (isset($_GET['t']) && explode('.', $f)[0] !== $_GET['t']) {
        continue;
    }
    $file = './cases/'.$f;
    $content = file_get_contents($file);
    $content = preg_replace('~<!--.+?-->~ms', '', $content);//dd($content)
    $cases = explode('-----', $content);
    $test = '';
    $expected = [];
    foreach ($cases as $case) {
        if (empty(trim($case))) {
            continue;
        }
        list($t, $exp) = explode('=====', $case);
        $test .= $t.PHP_EOL.'-----'.PHP_EOL;
        $expected[] = $exp;
    }
    $file = str_replace('cases/', 'temp/', $file);
    file_put_contents($file, $test);
    $rfilepath = str_replace('.template.php', '', $file);
    
    ob_start();
    $data = [];
    try {
        $parser->load($rfilepath);
    } catch(Exception $e) {
        echo $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine();
    }
    $results = ob_get_clean();
    //$results = explode('<body>', $results);
    //$results = end($results);
    $results = explode('-----',$results);
    foreach ($results as $i => $result) {
        if (empty($expected[$i])) {
            continue;
        }
        $_result = preg_replace('/[\n\r\t\s]*/', '', $result);
        $_expected = preg_replace('/[\n\r\t\s]*/', '', $expected[$i]);
        if ($_result === $_expected) {
            echo $f."[$i] passed \n";
        } else {
            echo $f."[$i] failed \n";
            echo "\nexpected\n{$expected[$i]}\ngained\n";
            echo $result;
            echo "\n$_expected\n$_result\n";
            /*
            $input = $cases[$i];
            $output = file_get_contents($dest);
            $output = explode('-----', $output);
            $output = $output[$i];
            echo "\ninput\n$input\n\noutput\n$output";*/
            die();
        }
    }
    unlink($file);
}
