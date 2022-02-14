<?php

require('../autoload.php');

use PhpTemplates\Entities\Php;
//dd(1);
echo Php::open('x');
echo Php::open('y');
echo Php::close('x');
echo Php::open('y');
echo Php::open('x');
echo Php::close('x');