<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['slot_default?id=61e318ff02c34'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',])));
     ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label><?php 
};
Parsed::$templates['slot_default?id=61e318ff03089'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['type','options','name','label','val','value',])));
      if ($type === 'text') { ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'number') { ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'email') { ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'checkbox') {  foreach ($options as $name => $label) { ?><label>
            <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'radio') {  foreach ($options as $val => $label) { ?><label>
            <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'select') { ?><select class="form-control">
            <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
        </select><?php }  elseif ($type === 'textarea') { ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php }  
};
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots','error',])));
     ?><div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php 
    if (!empty($this->slots["label"])) {
    foreach ($this->slots['label'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e318ff02c34', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e318ff03089', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div><?php 
};
Parsed::$templates['./cases/7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]);

    $this->comp[0]->render($data); ?>

-----</body></html><?php 
};