<?php

require('../autoload.php');

error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

?>
<style>
    body {
        background: black;
        color: gray;
    }
</style>
<?php

use PhpTemplates\TemplateFactory;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\EventDispatcher;
use PhpDom\DomNodeAttr;
use PhpDom\TextNode;

//header("Content-Type: text/plain");
$viewFactory = new TemplateFactory(__DIR__, __DIR__.'/error_results', new EventDispatcher());
//$cfgHolder = $viewFactory->getConfig();

$cfg = $viewFactory->config();
$eventHolder = $viewFactory->event();

$cfg->setDirective('error', function($node, $val) {
    $node->setAttribute(new DomNodeAttr('mydirective', 2));
});
$cfg->helper('error', function($t) {
    return $t->cfgKey().':doSomething';
});

$cfg = $cfg->subconfig('cases2', __DIR__.'/error_cases2/');
$cfg->setDirective('error2', function($node, $val) {
    $node->setAttribute(new DomNodeAttr('mydirective', 2));
});
$cfg->helper('error2', function($t) {
    return $t->cfgKey().':doSomething';
});

//$cfg->getRoot()->find('cases2'); die('66');
if (!is_dir('./error_results')) {
    mkdir('./error_results');
}

$files = array_diff(scandir('./error_results'), array('.', '..'));
foreach($files as $file){ // iterate files
    $file = './error_results/' . $file;
    if(is_file($file)) {
        unlink($file); // delete file
    }
}

$files = scandir('./error_cases');
$files = array_diff($files, ['.', '..', './']);

foreach($files as $f) {
    if (isset($_GET['t']) && explode('.', $f)[0] !== $_GET['t']) {
        continue;
    }
    $file = './error_cases/'.$f;
    $content = file_get_contents($file);
    $content = preg_replace('~<!--.+?-->~ms', '', $content);//dd($content)
    list($t, $expected) = explode('=====', $content);
    $rfilepath = str_replace(['.t.php', './'], '', $file);

    try {
        $view = $viewFactory->fromPath($rfilepath);
        $view->render();
        echo $rfilepath . ' failed because error expected'; die();
    } catch(Exception $e) {
        [$message, $f, $line] = explode('/', trim($expected));
        if (stripos($e->getMessage(), $message) === false || $e->getLine() != $line || stripos($e->getFile(), $f) === false) {
            dd($file, [$message, $f, $line], $e);
        }
    }
}
echo 'done';
// $viewFactory->fromRaw('<x-form-group type="text" name="y"/>')->render();