<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['b1?slot=18'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k',]));
     ?> <b11><?php echo htmlspecialchars($k); ?></b11> <?php 
};
Parsed::$templates['./temp/3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      foreach ([1,2] as $k) {   $this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=18", ['_index' => '1'])->setSlots($this->slots));  $this->comp[0]->render($this->data);  }  ?>

-----

 <?php 
};