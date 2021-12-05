<?php use DomDocument\PhpTemplates\Component; ?>
<?php Component::$templates['components/helper'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',]))); ?>
    <i class="fas fa-question-circle"></i>
<?php
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
<?php } ?>
<?php Component::$templates['components/helper_61ad0cc5042f6_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    h
<?php } ?>
<?php Component::$templates['slot_def_61ad0cc503faa'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/helper_61ad0cc5043ce_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    h
<?php } ?>
<?php Component::$templates['slot_def_61ad0cc5046e9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
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
    $comp = new Component('slot_def_61ad0cc5046e9', $data);
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
<?php Component::$templates['components/helper_61ad0cc5048ea_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    -x-
<?php } ?>
<?php Component::$templates['slot_def_61ad0cc5048c3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/helper_61ad0cc50499f_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    -x-
<?php } ?>
<?php Component::$templates['components/card_61ad0cc50486e_slot_title'] = function ($data, $slots) {
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
    $comp = new Component('slot_def_61ad0cc5048c3', $data);
    $comp->render($data);
    } ?>
<?php } ?>
<?php Component::$templates['slot_def_61ad0cc5053cc'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['slot_def_61ad0cc5055eb'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
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
    $comp = new Component('slot_def_61ad0cc5053cc', $data);
    $comp->render($data);
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, ['type' => $type]));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad0cc5055eb', $data);
    $comp->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
<?php } ?>
<?php Component::$templates['components/helper_61ad0cc505ddb_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    Helper
<?php } ?>
<?php Component::$templates['components/form-group_61ad0cc505da2_slot_label'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',]))); ?>
    <label slot="label"><?php
    $comp = new Component('components/helper', []);
    $comp->addSlot('default', new Component('components/helper_61ad0cc505ddb_slot_default', $data));
    $comp->render($data); ?> Label with helper</label>
<?php } ?>
<?php Component::$templates['components/card_61ad0cc504a58_slot_default'] = function ($data, $slots) {
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
    $comp = new Component('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'value' => 'some text']);
    $comp->addSlot('label', new Component('components/form-group_61ad0cc505da2_slot_label', $data));
    $comp->render($data); ?>
<?php } ?>
<?php Component::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',]))); ?>
    <extends layout="layouts/app"></extends>

<?php
    if (!empty($slots["ascomp"])) {
    foreach ($slots['ascomp'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad0cc503faa', $data);
    $comp->render($data);
    } 
    $comp = new Component('components/card', []);
    $comp->addSlot('title', new Component('components/card_61ad0cc50486e_slot_title', $data));
    $comp->addSlot('default', new Component('components/card_61ad0cc504a58_slot_default', $data));
    $comp->render($data); ?>
<?php } ?>
<?php Component::$templates['user-profile-form_61ad0cc505fad_slot_mytitle'] = function ($data, $slots) {
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
    $comp->addSlot('mytitle', new Component('user-profile-form_61ad0cc505fad_slot_mytitle', $data));
    $comp->render($data); ?>
    </body>
</html>

<?php } ?>
<?php (new Component('test'))->render($data); ?>