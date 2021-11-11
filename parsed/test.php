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
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <?php if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php } ?>
                <?php }
         ?>
        <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, []));}
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
  13 => 'type',
  14 => 'value',
  15 => 'placeholder',
  17 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
        }
        else  {
         ?>
                    <input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>">
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function slot_default_618cc1f3c60ba($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp0',
  1 => 'entry_firstname',
  2 => 'firstname',
  4 => 'data',
  6 => 'entry_lastname',
  7 => 'lastname',
)))); ?>
        <div class="row">
        <?php
            
            $comp0 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);
            $comp0->render($data); ?>
        <?php
            
            $comp0 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);
            $comp0->render($data); ?>
    </div>
        <?php } ?>
<?php function components_formgroup_40b1d_41dbf($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'type',
  14 => 'value',
  15 => 'placeholder',
  17 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
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
  13 => 'type',
  14 => 'options',
  15 => 'val',
  19 => 'value',
  21 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
        }
        else  {
         ?>
                    <select class="form-control">
                <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
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
  13 => 'type',
  14 => 'options',
  15 => 'name',
  18 => 'values',
  20 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
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
  13 => 'type',
  14 => 'options',
  15 => 'val',
  17 => 'name',
  19 => 'value',
  22 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
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
  13 => 'type',
  14 => 'placeholder',
  16 => '_attrs',
  17 => 'k',
  18 => 'v',
  21 => 'value',
  22 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
        }
        else  {
         ?>
                    <textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea>
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function components_helper_7bc48($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'slots',
  2 => 'slot',
  4 => 'data',
)))); ?>
        <i class="fas fa-question-circle"></i>
<?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render(array_merge($data, []));}
        }
         ?>
        <?php } ?>
<?php function slot_default_618cc1f3d1173($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
)))); ?>
        Helper
        <?php } ?>
<?php function slot_label_618cc1f3cfe69($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp0',
  1 => 'comp1',
  4 => 'data',
)))); ?>
        <label slot="label"><?php
            
            $comp0 = new Component('components_helper_7bc48', []);
            $comp1 = $comp0->addSlot('default', new Component('slot_default_618cc1f3d1173', []));
            $comp0->render($data); ?> Label with helper</label>
        <?php } ?>
<?php function slot_default_618cc1f3d165d($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
)))); ?>
        Helper
        <?php } ?>
<?php function slot_default_618cc1f3d17a9($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
)))); ?>
         Label with helper
        <?php } ?>
<?php function userprofileform_11181($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp0',
  1 => 'comp1',
  3 => 'comp2',
  5 => 'entry_firstname',
  6 => 'firstname',
  9 => 'entry_lastname',
  10 => 'lastname',
  13 => 'entry_email',
  14 => 'email',
  17 => 'entry_male',
  18 => 'entry_female',
  19 => 'entry_gender',
  20 => 'gender',
  29 => 'comp3',
  31 => 'comp4',
  36 => 'data',
)))); ?>
        <?php
            
            $comp0 = new Component('components_card_110b0', []);
            $comp1 = $comp0->addSlot('default', new Component('slot_default_618cc1f3c60ba', ['class' => 'row']));
            $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_84ae1', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]));
            $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_84ae1', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]));
            $comp1 = $comp0->addSlot('default', new Component('components_formgroup_40b1d_41dbf', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]));
            $comp1 = $comp0->addSlot('default', new Component('components_formgroup_40b1d_504ff', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]));
            $comp1 = $comp0->addSlot('default', new Component('components_formgroup_40b1d_530dc', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]));
            $comp1 = $comp0->addSlot('default', new Component('components_formgroup_40b1d_ba80a', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']));
            $comp1 = $comp0->addSlot('default', new Component('components_formgroup_40b1d_8b4ba', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'value' => 'some text']));
            $comp2 = $comp1->addSlot('label', new Component('slot_label_618cc1f3cfe69', []));
            $comp3 = $comp2->addSlot('default', new Component('components_helper_7bc48', []));
            $comp4 = $comp3->addSlot('default', new Component('slot_default_618cc1f3d165d', []));
            $comp3 = $comp2->addSlot('default', new Component('slot_default_618cc1f3d17a9', []));
            $comp0->render($data); ?>
        <?php } ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php
            
            $comp0 = new Component('userprofileform_11181', []);
            $comp0->render($data); ?>
    </body>
</html>
