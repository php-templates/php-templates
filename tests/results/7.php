<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['components/form-group'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="<?php echo Helper::mergeAttrs('form-group',!empty($class) ? $class : ''); ?>">
    
<?php foreach ($this->slots("label") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("label"))) { ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label>
<?php }  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("default"))) {  if ($type === 'text') {  ?><input type="text" class="form-control" value="<?php echo __r623741a7ec017; ?>" placeholder="<?php echo __r623741a7ec019; ?>">
<?php }   elseif ($type === 'number') {  ?><input type="number" class="form-control" value="<?php echo __r623741a7ec03b; ?>" placeholder="<?php echo __r623741a7ec03c; ?>">
<?php }   elseif ($type === 'email') {  ?><input type="email" class="form-control" value="<?php echo __r623741a7ec058; ?>" placeholder="<?php echo __r623741a7ec059; ?>">
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
<?php }   elseif ($type === 'textarea') {  ?><textarea class="form-control" <?php foreach($this->attrs as $k=>$v) echo "$k=\"$v\" "; ?> placeholder="<?php echo __r623741a7ec11b; ?>"><?php echo htmlspecialchars($value); ?></textarea>
<?php }   }  if (!empty($error)) {  ?><span class="error"><?php echo htmlspecialchars($error); ?></span>
<?php }  ?>
</div>

 <?php };
Parsed::$templates['./temp/7'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("components/form-group", ['type' => 'checkbox', 'name' => 'options', 'label' => 'Options', 'options' => ['o1' => 'A', 'o2' => 'B'], 'values' => ['o1']]);  $this->comp[0]->render($this->data); ?>

-----

 <?php };