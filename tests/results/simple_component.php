<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div>

 <?php 
};
Parsed::$templates['./temp/simple_component'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};