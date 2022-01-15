<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><!DOCTYPE html>
<html><body><div class="<?php echo htmlspecialchars(123); ?>"></div>

-----




<div class="<?php echo 123; ?>"></div>

-----</body></html><?php 
};