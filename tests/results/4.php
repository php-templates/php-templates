<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['extends/parent2'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <parent2>
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></parent2>

 <?php };
Parsed::$templates['extends/b'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b></b>

 <?php };
Parsed::$templates['./temp/4'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->scopeData['bind_me'] = 'bound';  $this->comp[0] = Parsed::template("extends/b", []);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };
new DomEvent('rendering', 'extends/b', function($template, $data) {
            $comp = Parsed::template('extends/parent2', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });