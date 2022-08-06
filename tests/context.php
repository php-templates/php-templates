<?php

require('../autoload.php');

use PhpTemplates\Context;

function assertsTrue($val) {
    
}

$data = [
    'str1' => 'c1_1',
    'str2' => 'c1_2',
    'arr1' => [1, 2],
    'arr2' => ['foo' => 'bar'],
    'obj' => (object) ['x' => 1],
];

$c1 = new Context($data);
$c2 = $c1->subcontext([
    'str1' => 'c2_1',
    'str2' => 'c2_2',
    'arr1' => [1, 2],
]);
$c3 = new Context();

//$c1->arr2['foo'] = 3;
//$c2->arr2['foo'] = 4;

$c2->loopStart();
foreach ([1,2] as $c2->str2) {
    d($c2->str2);
}
$c2->loopEnd();
dd($c2->str2);
die();
dd($c1, $c2);