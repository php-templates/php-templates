<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot','error',]));
     ?> <div class="<?php echo Helper::mergeAttrs('form-group',!empty($class) ? $class : ''); ?>">
    
<?php foreach ($this->slots("label") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("label"))) {
} ?>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("default"))) {
} ?><?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div> <?php 
};
Parsed::$templates['./cases/7'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html><body>
<?php $this->comp[0] = Parsed::template("components/form-group", ['type' => 'checkbox', 'name' => 'options', 'label' => 'Options', 'options' => ['o1' => 'A', 'o2' => 'B'], 'values' => ['o1']]);
$this->comp[0]->render($this->data); ?>

-----</body></html> <?php 
};