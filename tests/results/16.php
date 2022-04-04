<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['./temp/16'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  
    $true = 1;
 ?>

<div role="map-route" class="flex w-full sm:w-auto">
    
<?php if ($true) {  ?><a class="text-2xl font-serif font-semibold text-purple-900" href=""><i class="fas fa-book"></i><span class="text-lg text-blue-700"></span></a>
<?php if ($true) {  ?><span class="self-end text-sm font-semibold text-purple-800">, capitolul</span>
<?php }   else {  ?><a href="/" class="inline text-lg font-serif font-semibold text-purple-900"><i class="fas fa-home"></i> Home</a>
<?php }   }  ?></div>

-----

 <?php };