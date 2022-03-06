<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./cases/16'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['true',]));
     ?> <!DOCTYPE html>
<html>
<body><?php
    $true = 1;
?>
<div role="map-route" class="flex w-full sm:w-auto">
    
<?php ;
if ($true) { 
 ?><a class="text-2xl font-serif font-semibold text-purple-900" href=""><i class="fas fa-book"></i><span class="text-lg text-blue-700"></span></a>
<?php ;
if ($true) { 
 ?><span class="self-end text-sm font-semibold text-purple-800">, capitolul</span>
<?php ;
} 
else { 
 ?><a href="/" class="inline text-lg font-serif font-semibold text-purple-900"><i class="fas fa-home"></i> Home</a>
<?php ;
} 
} 
</div>
 ?>

-----</body></html> <?php 
};