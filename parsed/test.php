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
<?php function components_helper_7bc48($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'slots',
  2 => 'slot',
  4 => 'data',
)))); ?>
        <span class="help-circle">
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
         ?>
</span>
        <?php } ?>
<?php function slot_default_61856cd96dacf($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
)))); ?>
        Helper
        <?php } ?>
<?php function slot_label_61856cd96dc81($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp2',
  1 => 'comp3',
  4 => 'data',
)))); ?>
        <label><?php
            
        $comp2 = new Component('components_helper_7bc48', []);
                $comp3 = $comp2->addSlot('default', new Component('slot_default_61856cd96dacf', []));
        $comp2->render($data); ?> Label with helper</label>
        <?php } ?>
<?php function slot_default_61856cd96de9a($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
)))); ?>
        Helper
        <?php } ?>
<?php function userprofileform_11181($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp1',
  1 => 'comp2',
  4 => 'data',
)))); ?>
        <?php
            
        $comp1 = new Component('components_card_110b0', []);
                $comp2 = $comp1->addSlot('default', new Component('components_formgroup_40b1d_8b4ba', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'value' => 'some text']));
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
