<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></span>
</div> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>xjd</p> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>hdhd</p> <?php 
};
Parsed::$templates['comp/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <?php $this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[0]->render($this->data); ?> <?php 
};
Parsed::$templates['comp/a?slot=sn9&id=3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>9</p> <?php 
};
Parsed::$templates['./cases/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html><body>
<?php $this->comp[0] = Parsed::template("comp/a", []);
$this->comp[0]->render($this->data); ?>

-----</body></html> <?php 
};