<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['components/input-group'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['type','value','placeholder','label','options','name','values','val','_attrs','k','v',]));
     ?> <?php ;
if ($type === 'text') {
?>
<input type="text" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php ;
}


elseif ($type === 'number') {
?>
<input type="number" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php ;
}


elseif ($type === 'email') {
?>
<input type="email" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php ;
}


elseif ($type === 'checkbox') {
foreach ($options as $name => $label) {
?>
<label>
    <input type="checkbox" <?php echo (in_array($name, $values) ? 'checked' : '') ?> value="1">
    <?php echo htmlspecialchars($label); ?>
</label>
<?php ;
} 
}


elseif ($type === 'radio') {
foreach ($options as $val => $label) {
?>
<label>
    <input type="radio" <?php echo ($val == $value ? 'checked' : '') ?> name="<?php echo $name; ?>" value="<?php echo $val; ?>">
    <?php echo htmlspecialchars($label); ?>
</label>
<?php ;
} 
}


elseif ($type === 'select') {
?>
<select class="form-control">
    
<?php ;
foreach ($options as $val => $label) { 
 ?><option <?php echo ($val == $value ? 'checked' : '') ?> value="<?php echo $val; ?>"><?php echo htmlspecialchars($label); ?></option>
<?php ;
} 
 ?>
</select>
<?php ;
}


elseif ($type === 'textarea') {
?>
<textarea class="form-control" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?> placeholder="<?php echo $placeholder ?? $label; ?>"><?php echo htmlspecialchars($value); ?></textarea>
<?php ;
}
?>

 <?php 
};