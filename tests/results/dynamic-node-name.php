<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./cases/dynamic-node-name'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['i',]));
     ?> <!DOCTYPE html>
<html>
<body><?php echo '<div class="'.(true ? 'some-class' : '').'">'; ?>
    
<?php ;
foreach ([1,2] as $i) { 
 ?><p></p>
<?php ;
} 
 ?>
<?php echo '</div>'; ?>

-----</body></html> <?php 
};