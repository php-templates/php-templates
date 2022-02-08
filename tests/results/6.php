<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
      $this->data['val'] = [1,2]; $this->data['name'] = "myname"; ?><c>
    
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?>
</c> <?php 
};
Parsed::$templates['props/c?slot=default&id=15'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['props/c?slot=default&id=16'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['name','v',]));
     ?> <div><?php echo htmlspecialchars($name.$v); ?></div> <?php 
};
Parsed::$templates['props/c?slot=default&id=17'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['./cases/6'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','val','v',]));
     ?> <!DOCTYPE html>
<html>
<body>
<?php $this->comp[0] = Parsed::template("props/c", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("props/c?slot=default&id=15", []));<?php foreach ($val as $v) { ?>
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("props/c?slot=default&id=16", []));
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("props/c?slot=default&id=17", []));
$this->comp[0]->render($this->data);  } ?>

-----</body></html> <?php 
};