<?php use DomDocument\PhpTemplates\Component; ?>
<?php function components_card_110b0($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'slots',
  2 => 'slot',
  4 => 'data',
  5 => 'title',
)))); ?>
        <div class="card">
    <div class="card-body">
        <?php
            if (!empty($slots["title"])) {
        foreach ($slots["title"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <?php if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php } ?>
                <?php }
         ?>
        <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
         ?>
    </div>
</div>
        <?php } ?>
<?php function components_formgroup_40b1d_84ae1($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'value',
  14 => 'placeholder',
  16 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>">
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function slot_default_6184db3c18c0b($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp2',
  1 => 'entry_firstname',
  2 => 'firstname',
  4 => 'data',
  6 => 'entry_lastname',
  7 => 'lastname',
)))); ?>
        <div class="row">
        <?php
            
        $comp2 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);
        $comp2->render($data); ?>
        <?php
            
        $comp2 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);
        $comp2->render($data); ?>
    </div>
        <?php } ?>
<?php function components_formgroup_40b1d_41dbf($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'value',
  14 => 'placeholder',
  16 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>">
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function components_formgroup_40b1d_504ff($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'options',
  14 => 'val',
  18 => 'value',
  20 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <select class="form-control">
                <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? `checked='checked` : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
            </select>
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function components_formgroup_40b1d_530dc($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'options',
  14 => 'name',
  17 => 'values',
  19 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <?php foreach ($options as $name => $label) { ?><label>
                <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
                <?php echo htmlspecialchars($label); ?>
            </label><?php } ?>
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function components_formgroup_40b1d_ba80a($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'options',
  14 => 'val',
  16 => 'name',
  18 => 'value',
  21 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <?php foreach ($options as $val => $label) { ?><label>
                <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
                <?php echo htmlspecialchars($label); ?>
            </label><?php } ?>
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function components_formgroup_40b1d_8b4ba($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'placeholder',
  15 => '_attrs',
  16 => 'k',
  17 => 'v',
  20 => 'value',
  21 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea>
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function userprofileform_11181($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp1',
  1 => 'comp2',
  5 => 'entry_email',
  6 => 'email',
  9 => 'entry_male',
  10 => 'entry_female',
  11 => 'entry_gender',
  12 => 'gender',
  20 => 'data',
)))); ?>
        <?php
            
        $comp1 = new Component('components_card_110b0', []);
                $comp2 = $comp1->addSlot('default', new Component('slot_default_6184db3c18c0b', ['class' => 'row']));
                $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_41dbf', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]));
                $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_504ff', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]));
                $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_530dc', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]));
                $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_ba80a', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']));
                $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_8b4ba', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Comment', 'value' => 'some text']));
        $comp1->render($data); ?>
        <?php } ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    
    <body>
        <?php
            
        $comp0 = new Component('userprofileform_11181', []);
        $comp0->render($data); ?>
    </body>
</html>
