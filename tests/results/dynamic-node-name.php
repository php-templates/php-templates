<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./temp/dynamic-node-name'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      echo '<div class="'.(true ? 'some-class' : '').'">';  foreach ([1,2] as $i) {  ?>
<p></p>
<?php }   echo '</div>'; ?>

-----

 <?php 
};