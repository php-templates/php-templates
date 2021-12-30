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
Parsed::$templates['slot_default_61cd9182a93b2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['title',])));
     ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php 
};
Parsed::$templates['components/card'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','title','comp0',])));
     ?><div class="card">
    <div class="card-body">
        <?php 
    if (!empty($slots["title"])) {
    foreach ($slots['title'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    if (isset($title)) {$comp0 = Parsed::template('slot_default_61cd9182a93b2', ['class' => 'card-title']);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </div>
</div><?php 
};
Parsed::$templates['slot_default_61cd9182ac0a2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',])));
     ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label><?php 
};
Parsed::$templates['slot_default_61cd9182ac566'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','placeholder','label',])));
     ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php 
};
Parsed::$templates['slot_default_61cd9182acd09'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','placeholder','label',])));
     ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php 
};
Parsed::$templates['slot_default_61cd9182ad217'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','placeholder','label',])));
     ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php 
};
Parsed::$templates['slot_default_61cd9182ad737'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['name','values','label',])));
     ?><label>
            <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
            <?php echo htmlspecialchars($label); ?>
        </label><?php 
};
Parsed::$templates['61cd9182af2e8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['name','val','value','label',])));
     ?>
            <label>
                <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
                <?php echo htmlspecialchars($label); ?>
            </label>
        <?php 
};
Parsed::$templates['slot_default_61cd9182ae14d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['type','options','val','label','name','value',])));
     ?><component p-elseif="$type === 'radio'" p-foreach="$options as $val => $label" :val="$val" :label="$label">
            <label>
                <input type="radio" :name="$name" p-raw="$val == $value ? 'checked' : ''" :value="$val">
                <?php echo htmlspecialchars($label); ?>
            </label>
        </component><?php 
};
Parsed::$templates['slot_default_61cd9182afc4a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['options','val','label','value',])));
     ?><select class="form-control">
            <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
        </select><?php 
};
Parsed::$templates['slot_default_61cd9182b01df'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['placeholder','label','_attrs','k','v','value',])));
     ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php 
};
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['class','slots','slot','data','comp0','type','value','placeholder','label','options','name','val','error',])));
     ?><div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php 
    if (!empty($slots["label"])) {
    foreach ($slots['label'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default_61cd9182ac0a2', ['class' => 'form-label']);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    if ($type === 'text') {$comp0 = Parsed::template('slot_default_61cd9182ac566', ['type' => 'text', 'class' => 'form-control', 'value' => $value, 'placeholder' => $placeholder ?? $label]);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    elseif ($type === 'number') {$comp0 = Parsed::template('slot_default_61cd9182acd09', ['type' => 'number', 'class' => 'form-control', 'value' => $value, 'placeholder' => $placeholder ?? $label]);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    elseif ($type === 'email') {$comp0 = Parsed::template('slot_default_61cd9182ad217', ['type' => 'email', 'class' => 'form-control', 'value' => $value, 'placeholder' => $placeholder ?? $label]);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    elseif ($type === 'checkbox') {
    foreach ($options as $name => $label) {$comp0 = Parsed::template('slot_default_61cd9182ad737', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    }
    elseif ($type === 'radio') {
    foreach ($options as $val => $label) {$comp0 = Parsed::template('slot_default_61cd9182ae14d', ['val' => $val, 'label' => $label]);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    }
    elseif ($type === 'select') {$comp0 = Parsed::template('slot_default_61cd9182afc4a', ['class' => 'form-control']);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    elseif ($type === 'textarea') {$comp0 = Parsed::template('slot_default_61cd9182b01df', ['class' => 'form-control', 'placeholder' => $placeholder ?? $label]);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div><?php 
};
Parsed::$templates['components/card_slot_default_61cd9182aa0f2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','entry_firstname','firstname','data','entry_lastname','lastname',])));
     ?><div class="row">
        <?php $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);

    $comp0->render($data);  $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);

    $comp0->render($data); ?>
    </div><?php 
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
Parsed::$templates['components/helper_slot_default_61cd9182b3282'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>Helper<?php 
};
Parsed::$templates['components/card_slot_label_61cd9182b167e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><label><?php $comp0 = Parsed::template('components/helper', []);
$comp1 = $comp0->addSlot('default', Parsed::template('components/helper_slot_default_61cd9182b3282', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?> Label with helper</label><?php 
};
Parsed::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','entry_email','email','entry_male','entry_female','entry_gender','gender','comp2','data',])));
     ?><?php $comp0 = Parsed::template('components/card', ['title' => 'My form']);
$comp1 = $comp0->addSlot('default', Parsed::template('components/card_slot_default_61cd9182aa0f2', ['class' => 'row']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text']));
$comp2 = $comp1->addSlot('label', Parsed::template('components/card_slot_label_61cd9182b167e', []));

    $comp2->setSlots($slots);
    $comp0->render($data); ?><?php 
};
new DomEvent('rendering', 'user-profile-form', function($template, $data) {
            $comp = Parsed::template('layouts/app', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
Parsed::template('user-profile-form', [])->render($data); ?>