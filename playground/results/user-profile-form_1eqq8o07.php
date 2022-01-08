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
    } ?></body>
</html><?php 
};
Parsed::$templates['slot_default?id=61d9d4f6c3483'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['title',])));
      if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php }  
};
Parsed::$templates['components/card'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="card">
    <div class="card-body">
        <?php 
    if (!empty($slots["title"])) {
    foreach ($slots['title'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d9d4f6c3483', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></div>
</div><?php 
};
Parsed::$templates['slot_default?id=61d9d4f6c585f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',])));
     ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label><?php 
};
Parsed::$templates['slot_default?id=61d9d4f6c5c79'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['type','options','name','label','val','value',])));
      if ($type === 'text') { ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'number') { ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'email') { ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php }  elseif ($type === 'checkbox') {  foreach ($options as $name => $label) { ?><label>
            <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'radio') {  foreach ($options as $val => $label) { ?><label>
            <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
            <?php echo htmlspecialchars($label); ?>
        </label><?php }  }  elseif ($type === 'select') { ?><select class="form-control"><?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?></select><?php }  elseif ($type === 'textarea') { ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php }  
};
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0','error',])));
     ?><div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php 
    if (!empty($slots["label"])) {
    foreach ($slots['label'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d9d4f6c585f', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d9d4f6c5c79', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div><?php 
};
Parsed::$templates['block_form-fields_slot?id=61d9d4f6c4a73'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','entry_firstname','firstname','data','entry_lastname','lastname',])));
     ?><div class="row">
            <?php $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);

    $comp0->render($data);  $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);

    $comp0->render($data); ?></div><?php 
};
Parsed::$templates['form-fields?id=61d9d4f6c49ef'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot','entry_email','email','entry_male','entry_female','entry_gender','gender',])));
      $this->block['form-fields'] = Parsed::raw('form-fields', function($data, $slots) {
            extract($data);
            if (isset($slots['form-fields'])) {
                usort($slots['form-fields'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['form-fields'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('block_form-fields_slot?id=61d9d4f6c4a73', ['class' => 'row', '_index' => '0']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email, '_index' => '1']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender, '_index' => '2']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1'], '_index' => '3']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2', '_index' => '4']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text', '_index' => '5']))->setSlots($slots);
$this->block['form-fields']->render($data);  
};
Parsed::$templates['components/card_slot_default?id=61d9d4f6c3c64'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
      Parsed::template('form-fields?id=61d9d4f6c49ef', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
      $comp0 = Parsed::template('components/card', ['title' => 'My form']);
$comp1 = $comp0->addSlot('default', Parsed::template('components/card_slot_default?id=61d9d4f6c3c64', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  
};
new DomEvent('rendering', 'user-profile-form', function($template, $data) {
            $comp = Parsed::template('layouts/app', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });