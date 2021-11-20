<?php use DomDocument\PhpTemplates\Component; ?>
<?php function components_helper_7bc48($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'slots',  'slot',  'data',]))); ?>
        <i class="fas fa-question-circle"></i>
<?php
            if (!empty($slots["default"])) {
        foreach ($slots['default'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
         ?>
        <?php } ?>
<?php function slot_default_619967b35e72d($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
        h
        <?php } ?>
<?php function slot_def_619967b35de72($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'comp',  'data',]))); ?>
        <?php
            
            $comp = new Component('components_helper_7bc48', []);
                $comp->addSlot('default', new Component('slot_default_619967b35e72d', $data));
            $comp->render($data); ?>Slot with default as comp
        <?php } ?>
<?php function slot_default_619967b35e91c($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
        h
        <?php } ?>
<?php function slot_def_619967b35f3e6($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'title',]))); ?>
        <?php if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php } ?>
        <?php } ?>
<?php function components_card_110b0($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'slots',  'slot',  'data',  'comp',]))); ?>
        <div class="card">
    <div class="card-body">
        <?php
            if (!empty($slots["title"])) {
        foreach ($slots['title'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
        $comp = new Component('slot_def_619967b35f3e6', $data);$comp->render($data);}
         
            if (!empty($slots["default"])) {
        foreach ($slots['default'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
         ?>
    </div>
</div>
        <?php } ?>
<?php function slot_default_619967b35fea6($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
        -x-
        <?php } ?>
<?php function slot_def_619967b35fd97($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'comp',  'data',]))); ?>
        <?php
            
            $comp = new Component('components_helper_7bc48', []);
                $comp->addSlot('default', new Component('slot_default_619967b35fea6', $data));
            $comp->render($data); ?>
        <?php } ?>
<?php function slot_default_619967b36024e($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
        -x-
        <?php } ?>
<?php function slot_title_619967b35fb64($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'slots',  'slot',  'data',  'comp',]))); ?>
        <?php
            if (!empty($slots["default"])) {
        foreach ($slots['default'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
         
            if (!empty($slots["default"])) {
        foreach ($slots['default'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
        $comp = new Component('slot_def_619967b35fd97', $data);$comp->render($data);}
         ?>
        <?php } ?>
<?php function slot_def_619967b3611ed($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'label',]))); ?>
        <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
        <?php } ?>
<?php function slot_def_619967b3616dc($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'type',  'value',  'placeholder',  'label',  'options',  'name',  'values',  'val',  '_attrs',  'k',  'v',]))); ?>
        <?php if ($type === 'text') { ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'number') { ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'email') { ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'checkbox') {  foreach ($options as $name => $label) { ?><label>
            <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'radio') {  foreach ($options as $val => $label) { ?><label>
            <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'select') { ?><select class="form-control">
            <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
        </select><?php }  elseif ($type === 'textarea') { ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php } ?>
        <?php } ?>
<?php function components_formgroup_40b1d($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'class',  'slots',  'slot',  'data',  'comp',  'type',  'error',]))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots['label'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
        $comp = new Component('slot_def_619967b3611ed', $data);$comp->render($data);}
         
            if (!empty($slots["default"])) {
        foreach ($slots['default'] as $slot) {
        $slot->render(array_merge($data, ['type' => $type]));}
        }
        else  {
        $comp = new Component('slot_def_619967b3616dc', $data);$comp->render($data);}
          if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
<?php function slot_default_619967b363c21($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
        Helper
        <?php } ?>
<?php function slot_label_619967b363afd($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'comp',  'data',]))); ?>
        <label slot="label"><?php
            
            $comp = new Component('components_helper_7bc48', []);
                $comp->addSlot('default', new Component('slot_default_619967b363c21', $data));
            $comp->render($data); ?> Label with helper</label>
        <?php } ?>
<?php function slot_default_619967b3604d5($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'comp',  'entry_firstname',  'firstname',  'data',  'entry_lastname',  'lastname',  'entry_email',  'email',  'entry_male',  'entry_female',  'entry_gender',  'gender',]))); ?>
        <div class="row">
        <?php
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);
            $comp->render($data); 
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);
            $comp->render($data); ?>
    </div><?php
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]);
            $comp->render($data); 
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]);
            $comp->render($data); 
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]);
            $comp->render($data); 
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']);
            $comp->render($data); 
            
            $comp = new Component('components_formgroup_40b1d', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'value' => 'some text']);
                $comp->addSlot('label', new Component('slot_label_619967b363afd', $data));
            $comp->render($data); ?>
        <?php } ?>
<?php function userprofileform_11181($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [  'slots',  'slot',  'data',  'comp',]))); ?>
        <?php
            if (!empty($slots["ascomp"])) {
        foreach ($slots['ascomp'] as $slot) {
        $slot->render(array_merge($data, []));}
        }
        else  {
        $comp = new Component('slot_def_619967b35de72', $data);$comp->render($data);}
         
            
            $comp = new Component('components_card_110b0', []);
                $comp->addSlot('title', new Component('slot_title_619967b35fb64', $data));
                $comp->addSlot('default', new Component('slot_default_619967b3604d5', $data));
            $comp->render($data); ?>
        <?php } ?>
<?php function slot_mytitle_619967b36442c($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
        <div slot="mytitle">mytitle</div>
        <?php } ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php
            
            $comp = new Component('userprofileform_11181', []);
                $comp->addSlot('mytitle', new Component('slot_mytitle_619967b36442c', $data));
            $comp->render($data); ?>
    </body>
</html>
