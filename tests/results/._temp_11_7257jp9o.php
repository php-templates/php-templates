<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/simple'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp/simple">
    comp/simple
</div>

 <?php };
Parsed::$templates['./temp/11'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  foreach ([1,2] as $k) {   $this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("comp/simple", ['_index' => '1']));  $this->comp[0]->render($this->scopeData);  }  ?>

-----

 <?php };