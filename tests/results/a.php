<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></span>
</div>

 <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=20'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>xjd</p> <?php 
};
Parsed::$templates['sn9?slot=default&id=21'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> 
        djdh
         <?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div>

 <?php 
};
Parsed::$templates['sn9?slot=default&id=22'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/comp_slot?slot=default&id=23'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>hdhd</p> <?php 
};
Parsed::$templates['comp/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("comp/comp_slot", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=20", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  foreach ($this->slots("sn9") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}  if (empty($this->slots("sn9"))) { ;  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn9?slot=default&id=21", []));  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn9?slot=default&id=22", []));  }  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=23", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/a?slot=sn9&id=24'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>9</p> <?php 
};
Parsed::$templates['./temp/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("comp/a", []);  $this->comp[1] = $this->comp[0]->addSlot("sn9", Parsed::template("comp/a?slot=sn9&id=24", ['slot' => 'sn9', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};