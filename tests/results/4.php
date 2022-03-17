<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['extends/parent2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['bind_me',]));
     ?> <parent2>
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></parent2>

 <?php 
};
Parsed::$templates['extends/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b></b>

 <?php 
};
Parsed::$templates['./temp/4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->data['bind_me'] = 'bound';  $this->comp[0] = Parsed::template("extends/b", []);  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};
new DomEvent('rendering', 'extends/b', function($template, $data) {
            $comp = Parsed::template('extends/parent2', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });