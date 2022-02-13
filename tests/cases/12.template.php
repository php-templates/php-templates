<?php 
$array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
?>

<template is="comp/simple" p-if="$true"></template>
<elseif p-elseif="$true"></elseif>
=====
<div class="comp/simple">
    comp/simple
</div>