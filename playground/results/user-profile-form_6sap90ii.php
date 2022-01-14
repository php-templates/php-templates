<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_nav-items_slot?id=61db1f22aa3ab'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li><?php 
};
Parsed::$templates['block_nav-items_slot?id=61db1f22aa9b7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li><?php 
};
Parsed::$templates['block_nav-items_slot?id=61db1f22aacb5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li><?php 
};
Parsed::$templates['nav-items?id=61db1f22aa2bd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['nav-items'] = Parsed::raw('nav-items', function($data, $slots) {
            extract($data);
            if (isset($slots['nav-items'])) {
                usort($slots['nav-items'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['nav-items'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['nav-items']->addSlot('nav-items', Parsed::template('block_nav-items_slot?id=61db1f22aa3ab', ['class' => 'nav-item active', '_index' => '0']))->setSlots($slots);
$this->block['nav-items']->addSlot('nav-items', Parsed::template('block_nav-items_slot?id=61db1f22aa9b7', ['class' => 'nav-item', '_index' => '1']))->setSlots($slots);
$this->block['nav-items']->addSlot('nav-items', Parsed::template('block_nav-items_slot?id=61db1f22aacb5', ['class' => 'nav-item', '_index' => '2']))->setSlots($slots);
$this->block['nav-items']->render($data);  
};
Parsed::$templates['block_nav-right_slot?id=61db1f22ab207'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form><?php 
};
Parsed::$templates['nav-right?id=61db1f22ab19c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['nav-right'] = Parsed::raw('nav-right', function($data, $slots) {
            extract($data);
            if (isset($slots['nav-right'])) {
                usort($slots['nav-right'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['nav-right'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['nav-right']->addSlot('nav-right', Parsed::template('block_nav-right_slot?id=61db1f22ab207', ['class' => 'form-inline my-2 my-lg-0', '_index' => '0']))->setSlots($slots);
$this->block['nav-right']->render($data);  
};
Parsed::$templates['components/navbar'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><nav class="navbar navbar-expand-lg navbar-light bg-light"><a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"><?php Parsed::template('nav-items?id=61db1f22aa2bd', [])->setSlots($slots)->render($data); ?></ul><?php Parsed::template('nav-right?id=61db1f22ab19c', [])->setSlots($slots)->render($data); ?></div>
</nav><?php 
};
Parsed::$templates['layouts/app'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data','slots','slot',])));
     ?><!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
        <?php $comp0 = Parsed::template('components/navbar', []);

    $comp0->render($data);  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></body>
</html><?php 
};
Parsed::$templates['slot_default?id=61db1f22ae24a'] = function ($data, $slots) {
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
    else  {$comp0 = Parsed::template('slot_default?id=61db1f22ae24a', []);

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
Parsed::$templates['slot_default?id=61db1f22afc3d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',])));
     ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label><?php 
};
Parsed::$templates['slot_default?id=61db1f22afec8'] = function ($data, $slots) {
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
    else  {$comp0 = Parsed::template('slot_default?id=61db1f22afc3d', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61db1f22afec8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div><?php 
};
Parsed::$templates['block_form-fields_slot?id=61db1f22aee01'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','entry_firstname','firstname','data','entry_lastname','lastname',])));
     ?><div class="row">
            <?php $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);

    $comp0->render($data);  $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);

    $comp0->render($data); ?></div><?php 
};
Parsed::$templates['form-fields?id=61db1f22aed86'] = function ($data, $slots) {
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
$this->block['form-fields']->addSlot('form-fields', Parsed::template('block_form-fields_slot?id=61db1f22aee01', ['class' => 'row', '_index' => '0']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email, '_index' => '1']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender, '_index' => '2']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1'], '_index' => '3']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2', '_index' => '4']))->setSlots($slots);
$this->block['form-fields']->addSlot('form-fields', Parsed::template('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text', '_index' => '5']))->setSlots($slots);
$this->block['form-fields']->render($data);  
};
Parsed::$templates['components/card_slot_default?id=61db1f22aece8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
      Parsed::template('form-fields?id=61db1f22aed86', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
      $comp0 = Parsed::template('components/card', ['title' => 'My form']);
$comp1 = $comp0->addSlot('default', Parsed::template('components/card_slot_default?id=61db1f22aece8', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  
};
new DomEvent('rendering', 'user-profile-form', function($template, $data) {
            $comp = Parsed::template('layouts/app', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });