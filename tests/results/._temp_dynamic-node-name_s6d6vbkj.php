<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['./temp/dynamic-node-name'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  echo '<div class="'.(true ? 'some-class' : '').'">';  foreach ([1,2] as $i) {  ?>
<p></p>
<?php }   echo '</div>'; ?>

-----

 <?php };