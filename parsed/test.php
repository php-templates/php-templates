<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['layouts/app'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </body>
</html><?php 
};
Parsed::$templates['components/helper'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><i class="fas fa-question-circle"></i><?php
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?><?php 
};
Parsed::$templates['components/helper_61b4c2a146eda_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>h<?php 
};
Parsed::$templates['slot_def_61b4c2a1466b0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',])));
     ?><?php
    $comp = Parsed::template('components/helper', []);
    $comp->addSlot('default', Parsed::template('components/helper_61b4c2a146eda_slot_default', $data));
    $comp->render($data); ?>Slot with default as comp<?php 
};
Parsed::$templates['components/helper_61b4c2a14708a_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>h<?php 
};
Parsed::$templates['slot_def_61b4c2a147aaa'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['title',])));
     ?><?php if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php } ?><?php 
};
Parsed::$templates['components/card'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><div class="card">
    <div class="card-body">
        <?php
    if (!empty($slots["title"])) {
    foreach ($slots['title'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61b4c2a147aaa', $data);
    $comp->render($data);
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </div>
</div><?php 
};
Parsed::$templates['components/helper_61b4c2a148909_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>-x-<?php 
};
Parsed::$templates['slot_def_61b4c2a14883c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',])));
     ?><?php
    $comp = Parsed::template('components/helper', []);
    $comp->addSlot('default', Parsed::template('components/helper_61b4c2a148909_slot_default', $data));
    $comp->render($data); ?><?php 
};
Parsed::$templates['components/helper_61b4c2a148c9c_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>-x-<?php 
};
Parsed::$templates['components/card_61b4c2a148650_slot_title'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><?php
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
    $comp = Parsed::template('slot_def_61b4c2a14883c', $data);
    $comp->render($data);
    } ?><?php 
};
Parsed::$templates['slot_def_61b4c2a149d0a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',])));
     ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label><?php 
};
Parsed::$templates['slot_def_61b4c2a14a379'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['type','value','placeholder','label','options','name','values','val','_attrs','k','v',])));
     ?><?php if ($type === 'text') { ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'number') { ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'email') { ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'checkbox') {  foreach ($options as $name => $label) { ?><label>
            <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'radio') {  foreach ($options as $val => $label) { ?><label>
            <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'select') { ?><select class="form-control">
            <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
        </select><?php }  elseif ($type === 'textarea') { ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php } ?><?php 
};
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['class','slots','slot','data','comp','type','error',])));
     ?><div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
    if (!empty($slots["label"])) {
    foreach ($slots['label'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61b4c2a149d0a', $data);
    $comp->render($data);
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, ['type' => $type]));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61b4c2a14a379', $data);
    $comp->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div><?php 
};
Parsed::$templates['components/helper_61b4c2a14cb1b_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>Helper<?php 
};
Parsed::$templates['components/form-group_61b4c2a14caac_slot_label'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',])));
     ?><label slot="label"><?php
    $comp = Parsed::template('components/helper', []);
    $comp->addSlot('default', Parsed::template('components/helper_61b4c2a14cb1b_slot_default', $data));
    $comp->render($data); ?> Label with helper</label><?php 
};
Parsed::$templates['block_extra-fields_slot_61b4c2a14cd64'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><?php 
};
Parsed::$templates['block_extra-fields_slot_61b4c2a14ced7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><?php 
};
Parsed::$templates['components/card_61b4c2a148faa_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','entry_firstname','firstname','data','entry_lastname','lastname','entry_email','email','entry_male','entry_female','entry_gender','gender','blocks','_name','slots','slot','block',])));
     ?><div class="row">
        <?php
    $comp = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);
    $comp->render($data); 
    $comp = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);
    $comp->render($data); ?>
    </div><?php
    $comp = Parsed::template('components/form-group', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]);
    $comp->render($data); 
    $comp = Parsed::template('components/form-group', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]);
    $comp->render($data); 
    $comp = Parsed::template('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]);
    $comp->render($data); 
    $comp = Parsed::template('components/form-group', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']);
    $comp->render($data); 
    $comp = Parsed::template('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text']);
    $comp->addSlot('label', Parsed::template('components/form-group_61b4c2a14caac_slot_label', $data));
    $comp->render($data); 
    $blocks = [];echo $_name;
    $blocks[] = Parsed::template('block_extra-fields_slot_61b4c2a14cd64', []);
    $blocks[] = Parsed::template('components/form-group', ['type' => 'text', 'name' => 'ef1', 'label' => 'ef1', 'value' => '']);
    $blocks[] = Parsed::template('block_extra-fields_slot_61b4c2a14ced7', []);
    if (isset($slots['extra-fields'])) {
    foreach ($slots['extra-fields'] as $slot) {
    $blocks[] = $slot;
    }
    }
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><extends template="layouts/app"></extends><?php
    if (!empty($slots["ascomp"])) {
    foreach ($slots['ascomp'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61b4c2a1466b0', $data);
    $comp->render($data);
    } 
    $comp = Parsed::template('components/card', []);
    $comp->addSlot('title', Parsed::template('components/card_61b4c2a148650_slot_title', $data));
    $comp->addSlot('default', Parsed::template('components/card_61b4c2a148faa_slot_default', $data));
    $comp->render($data); ?><?php 
};
Parsed::$templates['user-profile-form_61b4c2a14d68f_slot_mytitle'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div slot="mytitle">mytitle</div><?php 
};
Parsed::$templates['user-profile-form_61b4c2a14d736_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',])));
     ?><?php
    $comp = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'extra-fields', 'name' => 'firstname', 'label' => 'ef2', 'value' => 'ef2']);
    $comp->render($data); ?><?php 
};
Parsed::$templates['test'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',])));
     ?><!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php
    $comp = Parsed::template('user-profile-form', []);
    $comp->addSlot('mytitle', Parsed::template('user-profile-form_61b4c2a14d68f_slot_mytitle', $data));
    $comp->addSlot('default', Parsed::template('user-profile-form_61b4c2a14d736_slot_default', $data));
    $comp->render($data); ?>
    </body>
</html><?php 
};
new DomEvent('rendering', 'user-profile-form', function($template, $data) {
            $comp = Parsed::template('layouts/app');
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
Parsed::template('test', $data)->render(); ?>