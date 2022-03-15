<?php

require('../autoload.php');

use PhpTemplates\Entities\PhpTag;

//dd(1);
echo PhpTag::open('x');
echo PhpTag::open('y');
echo PhpTag::close('x');
echo PhpTag::open('y');
echo PhpTag::open('x');
echo PhpTag::close('x');