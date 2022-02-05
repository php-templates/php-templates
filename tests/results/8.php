<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/8'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><!DOCTYPE html>
<html>
<body><div class="<?php echo htmlspecialchars(123); ?>"></div>

-----




<div class="<?php echo 123; ?>"></div>

-----</body></html><?php 
};