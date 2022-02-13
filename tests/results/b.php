<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['b1?slot=8'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11></b11> <?php 
};
Parsed::$templates['b12?slot=9'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b121></b121> <?php 
};
Parsed::$templates['b122?slot=11'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b1221></b1221> <?php 
};
Parsed::$templates['b12?slot=10'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <n>
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b122")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("b122?slot=11", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data); ?></n> <?php 
};
Parsed::$templates['b2?slot=12'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b21></b21> <?php 
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <b>
    
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=8", ['_index' => '1'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("***block", ['_index' => '2'])->withName("b12")->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=9", ['_index' => '1'])->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=10", ['_index' => '2'])->setSlots($this->slots));
$this->comp[0]->render($this->data); ?></b><?php $this->comp[0] = Parsed::template("***block", [])->withName("b2")->setSlots($this->slots);$this->comp[1] = $this->comp[0]->addSlot("b2", Parsed::template("b2?slot=12", ['_index' => '1'])->setSlots($this->slots));$this->comp[0]->render($this->data); ?> <?php 
};
Parsed::$templates['block/b?slot=b1&id=13'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b12></b12> <?php 
};
Parsed::$templates['block/b?slot=b12&id=14'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b122></b122> <?php 
};
Parsed::$templates['block/b?slot=b122&id=15'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b1222></b1222> <?php 
};
Parsed::$templates['./cases/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html><body>
<?php $this->comp[0] = Parsed::template("block/b", []);;
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("block/b?slot=b1&id=13", ['_index' => '2.5']));
$this->comp[1] = $this->comp[0]->addSlot("b12", Parsed::template("block/b?slot=b12&id=14", ['_index' => '2.5']));
$this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("block/b?slot=b122&id=15", ['_index' => '99']));
$this->comp[0]->render($this->data); ?>

-----</body></html> <?php 
};