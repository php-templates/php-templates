<?php

require('../autoload.php');

use DomDocument\PhpTemplates\Facades\Config;
use DomDocument\PhpTemplates\Document;
use DomDocument\PhpTemplates\Parser;
use DomDocument\PhpTemplates\Parsed;
use IvoPetkov\HTML5DOMDocument;

Config::set('aliased', [
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
]);

Config::set('src_path', './');
Config::set('dest_path', './results/');

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
        list($t, $exp) = explode('=====', $case);
        $test .= $t.PHP_EOL.'-----'.PHP_EOL;
        $expected[] = $exp;
    }
    $rfilepath = str_replace('.template.php', '', $file);
    $doc = new Document($rfilepath);
    $parser = new Parser($doc, $rfilepath);
    $dom = new HTML5DOMDocument;
    $dom->loadHtml($parser->escapeSpecialCharacters($parser->removeHtmlComments($test)));
    $parser->parse($dom);
    $dest = './results/'.str_replace('.template', '', $f);
    if (!isset($_GET['edit'])) {
        $doc->save($dest);
    }
    ob_start();
    $data = [];
    include $dest;
    Parsed::template($rfilepath)->render();
    $results = ob_get_clean();
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
            echo "\n$_expected\n$_result";
            die();
        }
    }
}
