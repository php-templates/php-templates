<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot" i="0">
    <span i="0">
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, ['i' => '0']));
} ?></span>
</div> <?php 
};
Parsed::$templates['b1?slot=1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11 i="1">123</b11> <?php 
};
Parsed::$templates['./cases/1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html i="0"><body i="0">
<?php $this->comp[0] = Parsed::template("comp/comp_slot", ['i' => '0']);
$this->comp[0]->render($this->data); ?><template>
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("***block", ['i' => '1'])->withName("b1")->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=1", ['i' => '2']));SimpleNodeBlock<block><b11 i="1">123</b11></block></template>

-----</body></html> <?php 
};