<?php

namespace PhpTemplates;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../autoload.php');

use PhpTemplates\View;
use PhpTemplates\TemplateRepository;
use PhpTemplates\Context;

$context = $c = new Context();

final class K /*extends \__PHP_Incomplete_Class*/ {
    public function __toString() {
        return '';
    }
    
    public function __toBoolean() {
        return false;
    }
    public function __toBool() {
        return false;
    }
}
if (new \stdClass) {
    echo 1;
}
print_r(get_class_methods(new \__PHP_Incomplete_Class));


die();
$c->a = 1;
$c->a;
var_dump($c->a === 1);
$c->x = $c->d;
var_dump(is_null($c->x) && is_null($c->d) && count($c->all()) == 2);
$c->x['y']['z'] = $c->d;
$c->x = 1; $c->x;
var_dump($c->x === 1);
$c->n['b'] = 1;
var_dump(isset($c->n));
$c->l['m'] = 1;
var_dump(isset($c->all()['l']));

/*
//$c->x = $c->d;
//$context->x['y']['z'];
$context->x['y']['z'] = 123;
$context->y;
$context->g['n']['c']['r'] = 3;
var_dump($context->yoy);
var_dump(isset($context->yoy));
var_dump(!empty($context->yoy));
echo $context->yoy;
print_r($context->all());

//if (!empty($context->body_scripts)) {
    (new Loop($context->_context, $context->body_scripts))->run(function($context) {
        echo $context->bscript;
    }, 'bscript', null);
//}

//if ($context->size) {
  $context->class[] = 'form-control-';//.$context->size;
//}
$context->class[] = 1;// = implode(' ', $context->class);
$context->undef = $context->undef;
$context->undefi = (array)$context->undefi;
$c->c['val'] = 1;
$c->c = 2;
$c->c;

print_r($context);
die('done');
*/