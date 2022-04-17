<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['components/form-group'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="<?php echo Helper::mergeAttrs('form-group',!empty($class) ? $class : ''); ?>">
    
<?php foreach ($this->slots("label") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("label"))) { ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label>
<?php }  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("default"))) {  if ($type === 'text') {  ?><input type="text" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php }   elseif ($type === 'number') {  ?><input type="number" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php }   elseif ($type === 'email') {  ?><input type="email" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php }   elseif ($type === 'checkbox') { 
foreach ($options as $name => $label) {  ?><label>
            <input type="checkbox" <?php echo in_array($name, $values) ? 'checked' : ''; ?> value="1">
            <?php echo htmlspecialchars($label); ?>
        </label>
<?php } 
}   elseif ($type === 'radio') { 
foreach ($options as $val => $label) {  ?><label>
            <input type="radio" <?php echo $val == $value ? 'checked' : ''; ?> name="<?php echo $name; ?>" value="<?php echo $val; ?>">
            <?php echo htmlspecialchars($label); ?>
        </label>
<?php } 
}   elseif ($type === 'select') {  ?><select class="form-control">
            
<?php foreach ($options as $val => $label) {  ?><option <?php echo $val == $value ? 'checked' : ''; ?> value="<?php echo $val; ?>"><?php echo htmlspecialchars($label); ?></option>
<?php }  ?>
        </select>
<?php }   elseif ($type === 'textarea') {  ?><textarea class="form-control" <?php foreach($this->attrs as $k=>$v) echo "$k=\"$v\" "; ?> placeholder="<?php echo $placeholder ?? $label; ?>"><?php echo htmlspecialchars($value); ?></textarea>
<?php }   }  if (!empty($error)) {  ?><span class="error"><?php echo htmlspecialchars($error); ?></span>
<?php }  ?>
</div>

 <?php };
Parsed::$templates['./temp/7'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("components/form-group", ['type' => 'checkbox', 'name' => 'options', 'label' => 'Options', 'options' => ['o1' => 'A', 'o2' => 'B'], 'values' => ['o1']]);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };