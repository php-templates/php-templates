<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['props/c'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->scopeData['val'] = [1,2]; $this->scopeData['name'] = "myname"; ?>

<c>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></c>

 <?php };
Parsed::$templates['props/c?slot=default&id=19'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  foreach ($val as $v) {  ?><div><?php echo htmlspecialchars($name.$v); ?></div>
<?php }   };
Parsed::$templates['./temp/6'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("props/c", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("props/c?slot=default&id=19", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };