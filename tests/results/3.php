<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['b1?slot=4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k',]));
     ?> <b11><?php echo htmlspecialchars($k); ?></b11> <?php 
};
Parsed::$templates['./cases/3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k','this',]));
     ?> <html><body>
<?php ;
foreach ([1,2] as $k) { 
$this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=4", ['_index' => 1])->setSlots($this->slots));
$this->comp[0]->render($this->data);
} 
 ?>

-----</body></html> <?php 
};