<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['components/input-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['type','options','name','label','val','value',])));
      if ($type === 'text') { ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'number') { ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'email') { ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'checkbox') {  foreach ($options as $name => $label) { ?><label>
    <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
    <?php echo htmlspecialchars($label); ?>
</label><?php }  }  elseif ($type === 'radio') {  foreach ($options as $val => $label) { ?><label>
    <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
    <?php echo htmlspecialchars($label); ?>
</label><?php }  }  elseif ($type === 'select') { ?><select class="form-control"><?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?></select><?php }  elseif ($type === 'textarea') { ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php }  
};