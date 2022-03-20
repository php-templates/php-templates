<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['./temp/8'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="<?php echo htmlspecialchars(123); ?>"></div>

-----

<div class="<?php echo 123; ?>"></div>

-----

 <?php };