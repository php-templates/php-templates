<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./temp/8'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="<?php echo htmlspecialchars(123); ?>"></div>

-----

<div class="<?php echo 123; ?>"></div>

-----

 <?php 
};