<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['b1?slot=25'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11></b11> <?php 
};
Parsed::$templates['b12?slot=26'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b121></b121> <?php 
};
Parsed::$templates['b122?slot=28'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b1221></b1221> <?php 
};
Parsed::$templates['b12?slot=27'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <n>
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b122")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("b122?slot=28", ['_index' => '1'])->setSlots($this->slots));  $this->comp[0]->render($this->data); ?></n> <?php 
};
Parsed::$templates['b2?slot=29'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b21></b21> <?php 
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b>
    
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=25", ['_index' => '1'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("***block", ['_index' => '2'])->withName("b12")->setSlots($this->slots));  $this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=26", ['_index' => '1'])->setSlots($this->slots));  $this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=27", ['_index' => '2'])->setSlots($this->slots));  $this->comp[0]->render($this->data); ?></b>


<?php $this->comp[0] = Parsed::template("***block", [])->withName("b2")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b2", Parsed::template("b2?slot=29", ['_index' => '1'])->setSlots($this->slots));  $this->comp[0]->render($this->data);  
};
Parsed::$templates['block/b?slot=b1&id=30'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b12></b12> <?php 
};
Parsed::$templates['block/b?slot=b12&id=31'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b122></b122> <?php 
};
Parsed::$templates['block/b?slot=b122&id=32'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b1222></b1222> <?php 
};
Parsed::$templates['./temp/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("block/b", []);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("block/b?slot=b1&id=30", ['slot' => 'b1', '_index' => '2.5'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("b12", Parsed::template("block/b?slot=b12&id=31", ['slot' => 'b12', '_index' => '2.5'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("block/b?slot=b122&id=32", ['slot' => 'b122', '_index' => '99'])->setSlots($this->slots));  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};