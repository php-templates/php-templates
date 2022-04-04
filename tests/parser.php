<?php

require('../autoload.php');

use PhpTemplates\Config;
use PhpTemplates\Parsed;
use PhpTemplates\Template;
use PhpTemplates\Document;
use PhpTemplates\Process;
use PhpTemplates\TemplateFunction;

header("Content-Type: text/plain");

$cfg = new Config('./', './results/');
$cfg->addAlias('x-form-group', 'components/form-group');
$cfg->addAlias('x-input-group', 'components/input-group');
$cfg->addAlias('x-card', 'components/card');
$cfg->addAlias('x-helper', 'components/helper');

$cfg->addDirective('checked', function($eval) {
    return [
        'p-raw' => $eval.' ? "checked" : ""'
    ];
});

Template::setConfig('default', $cfg);

$files = scandir('./cases');
$files = array_diff($files, ['.', '..', './']);
//dd(Config::all());
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
    $process = new Process($rfilepath, $cfg);
    // $dom = new HTML5DOMDocument;
    // cream un context nou pentru a preprocesa continutul
    //$dom->loadHtml($parser->escapeSpecialCharacters($parser->removeHtmlComments($test)));
    $parser = new TemplateFunction($process, $rfilepath);
    $parser->parse();
    $doc = new Document($rfilepath, $process->getResult());

    $dest = './results/'.str_replace('.template', '', $f);
    if (!isset($_GET['edit'])) {
        $doc->save($dest);
    }
    ob_start();
    $data = [];
    include $dest;
    Parsed::template($rfilepath)->render();
    $results = ob_get_clean();//dd($results);
    $results = explode('<body>', $results);
    $results = end($results);
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
            
            $input = $cases[$i];
            $output = file_get_contents($dest);
            $output = explode('-----', $output);
            $output = $output[$i];
            echo "\ninput\n$input\n\noutput\n$output";
            die();
        }
    }
    unlink($file);
}
