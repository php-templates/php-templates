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
<?php Component::$templates['components/helper_61ad0b520c3c8_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['slot_def_61ad0b520c150'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/helper_61ad0b520c9a6_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['slot_def_61ad0b520ce92'] = function ($data, $slots) {
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
    $comp = new Component('slot_def_61ad0b520ce92', $data);
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
<?php Component::$templates['components/helper_61ad0b520d2aa_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['slot_def_61ad0b520d286'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/helper_61ad0b520d75d_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/card_61ad0b520d235_slot_title'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['slot_def_61ad0b520e840'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['slot_def_61ad0b520ed46'] = function ($data, $slots) {
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
    $comp = new Component('slot_def_61ad0b520e840', $data);
    $comp->render($data);
    } 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, ['type' => $type]));
    }
    }
    else  {
    $comp = new Component('slot_def_61ad0b520ed46', $data);
    $comp->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
<?php } ?>
<?php Component::$templates['components/helper_61ad0b520f592_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/form-group_61ad0b520f560_slot_label'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['components/card_61ad0b520e14f_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
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
    $comp = new Component('slot_def_61ad0b520c150', $data);
    $comp->render($data);
    } 
    $comp = new Component('components/card', []);
    $comp->addSlot('title', new Component('components/card_61ad0b520d235_slot_title', $data));
    $comp->addSlot('default', new Component('components/card_61ad0b520e14f_slot_default', $data));
    $comp->render($data); ?>
<?php } ?>
<?php Component::$templates['user-profile-form_61ad0b520fd13_slot_mytitle'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, []))); ?>
    
<?php } ?>
<?php Component::$templates['test'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp','data',]))); ?>
    
        <?php
    $comp = new Component('user-profile-form', []);
    $comp->addSlot('mytitle', new Component('user-profile-form_61ad0b520fd13_slot_mytitle', $data));
    $comp->render($data); ?>
    
<?php } ?>
<?php (new Component('test'))->render($data); ?>