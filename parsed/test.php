<?php use DomDocument\PhpTemplates\Component; ?>
<?php Component::$templates['components/helper'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',]))); ?>
    <i class="fas fa-question-circle"></i><?php
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
<?php } ?>
<?php Component::$templates['components/helper_61ad139dcdbfa_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    h
<?php } ?>
<?php Component::$templates['slot_def_61ad139dccc4b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',]))); ?>
    <?php
    $comp = new Component('components/helper', []);
    $comp->addSlot('default', new Component('components/helper_61ad139dcdbfa_slot_default', $data));
    $comp->render($data); ?>Slot with default as comp
<?php } ?>
<?php Component::$templates['components/helper_61ad139dce053_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    h
<?php } ?>
<?php Component::$templates['slot_def_61ad139dcf4e8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['title',]))); ?>
    <?php if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php } ?>
<?php } ?>
<?php Component::$templates['components/card'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',]))); ?>
    <div class="card">
    <div class="card-body">
        <?php
    if (!empty($slots["title"])) {
    foreach ($slots['title'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad139dcf4e8', $data);
    $comp->render($data);
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </div>
</div>
<?php } ?>
<?php Component::$templates['components/helper_61ad139dd0350_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    -x-
<?php } ?>
<?php Component::$templates['slot_def_61ad139dd0266'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',]))); ?>
    <?php
    $comp = new Component('components/helper', []);
    $comp->addSlot('default', new Component('components/helper_61ad139dd0350_slot_default', $data));
    $comp->render($data); ?>
<?php } ?>
<?php Component::$templates['components/helper_61ad139dd0757_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    -x-
<?php } ?>
<?php Component::$templates['components/card_61ad139dd0068_slot_title'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',]))); ?>
    <?php
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad139dd0266', $data);
    $comp->render($data);
    } ?>
<?php } ?>
<?php Component::$templates['slot_def_61ad139dd1908'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',]))); ?>
    <label class="form-label"><?php echo htmlspecialchars($label); ?></label>
<?php } ?>
<?php Component::$templates['slot_def_61ad139dd24cf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['type','value','placeholder','label','options','name','values','val','_attrs','k','v',]))); ?>
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
<?php Component::$templates['components/form-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['class','slots','slot','data','comp','type','error',]))); ?>
    <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
    if (!empty($slots["label"])) {
    foreach ($slots['label'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad139dd1908', $data);
    $comp->render($data);
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, ['type' => $type]));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad139dd24cf', $data);
    $comp->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
<?php } ?>
<?php Component::$templates['components/helper_61ad139dd6363_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    Helper
<?php } ?>
<?php Component::$templates['components/form-group_61ad139dd61f7_slot_label'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',]))); ?>
    <label slot="label"><?php
    $comp = new Component('components/helper', []);
    $comp->addSlot('default', new Component('components/helper_61ad139dd6363_slot_default', $data));
    $comp->render($data); ?> Label with helper</label>
<?php } ?>
<?php Component::$templates['components/card_61ad139dd0b6c_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','entry_firstname','firstname','data','entry_lastname','lastname','entry_email','email','entry_male','entry_female','entry_gender','gender',]))); ?>
    <div class="row">
        <?php
    $comp = new Component('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);
    $comp->render($data); 
    $comp = new Component('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);
    $comp->render($data); ?>
    </div><?php
    $comp = new Component('components/form-group', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]);
    $comp->render($data); 
    $comp = new Component('components/form-group', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]);
    $comp->render($data); 
    $comp = new Component('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]);
    $comp->render($data); 
    $comp = new Component('components/form-group', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']);
    $comp->render($data); 
    $comp = new Component('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text']);
    $comp->addSlot('label', new Component('components/form-group_61ad139dd61f7_slot_label', $data));
    $comp->render($data); ?>
<?php } ?>
<?php Component::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',]))); ?>
    <extends layout="layouts/app"></extends><?php
    if (!empty($slots["ascomp"])) {
    foreach ($slots['ascomp'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad139dccc4b', $data);
    $comp->render($data);
    } 
    $comp = new Component('components/card', []);
    $comp->addSlot('title', new Component('components/card_61ad139dd0068_slot_title', $data));
    $comp->addSlot('default', new Component('components/card_61ad139dd0b6c_slot_default', $data));
    $comp->render($data); ?>
<?php } ?>
<?php Component::$templates['user-profile-form_61ad139dd8469_slot_mytitle'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    <div slot="mytitle">mytitle</div>
<?php } ?>
<?php Component::$templates['test'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',]))); ?>
    <!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php
    $comp = new Component('user-profile-form', []);
    $comp->addSlot('mytitle', new Component('user-profile-form_61ad139dd8469_slot_mytitle', $data));
    $comp->render($data); ?>
    </body>
</html>
<?php } ?>
<?php (new Component('test'))->render($data); ?>