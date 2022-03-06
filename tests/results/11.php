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
Parsed::$templates['./cases/11'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k','this',]));
     ?> <!DOCTYPE html>
<html><body>
<?php ;
foreach ([1,2] as $k) { 
$this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("comp/simple", ['_index' => '1']));
$this->comp[0]->render($this->data);
} 
 ?>

-----</body></html> <?php 
};