<?php

require('../autoload.php');

use PhpTemplates\Template;
use PhpTemplates\Dom\DomNodeAttr;

//header("Content-Type: text/plain");
$viewFactory = new Template(__DIR__, __DIR__.'/results');
//$cfgHolder = $viewFactory->getConfig();

$cfg = $viewFactory->getConfig();
$eventHolder = $viewFactory->getEventHolder();
$eventHolder->on('parsing', 'cases2:cfg2-3', function($node) {
    $node->querySelector('div')->appendChild('text');
});

$cfg->setAlias([
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper'
]);

$cfg = $cfg->subconfig('cases2', __DIR__.'/cases2/');
$cfg->setAlias('x-form-group', 'cases2:components/form-group');
$cfg->setDirective('mydirective', function($node, $val) {
    $node->addAttribute(new DomNodeAttr('mydirective', 2));
});

//$cfg->getRoot()->find('cases2'); die('66');
if (!is_dir('./results')) {
    mkdir('./results');
}
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
    $rfilepath = str_replace(['.t.php', './'], '', $file);

    ob_start();
    $data = [];
    try {
        $view = $viewFactory->make($rfilepath);
        $view->render();
        $results = ob_get_clean();
    } catch(Exception $e) {
        $_f = str_replace('\\', '/', $e->getFile());
        $_f = explode('/', $_f);
        echo $e->getMessage() . ' in ' . end($_f) . ' at line ' . $e->getLine();
    }
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

$viewFactory->makeRaw('<x-form-group type="text" name="y"/>')->render();