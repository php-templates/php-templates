<?php

require('../autoload.php');

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\QuerySelector;

$html = '
<div class="class1">
    <span id="id"></span>
</div>
<div class="class2">
    <span id="id" a></span>
</div>
<div class="class1">
    <span id="id"></span>    
</div>
<span class="class1">
    <span id="id"></span>    
</span>';

$node = DomNode::fromString($html);
$result = $node->querySelector('.class2 > #id');
foreach ($result as $r)
{
    d("\n-----\n".$r);
}