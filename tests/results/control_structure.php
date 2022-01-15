<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/simple_slot_default?id=61e3166942090'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
    comp/simple
<?php 
};
Parsed::$templates['comp/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','data',])));
      
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }  foreach ([1,2] as $a) { ?><div class="comp/composed">
    <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?>
    comp/simple
    <span>
        <?php 
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?>
    </span>
</div><?php }  
};
Parsed::$templates['comp/csf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['i','slots','slot','data',])));
     ?><div class="comp_slot">
    <?php 
    for ($i=0;$i<2;$i++) {
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    } ?>
</div><?php 
};
Parsed::$templates['comp/csf_slot_default?id=61e3166944aab'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>x2<?php 
};
Parsed::$templates['comp/csf_slot_default?id=61e3166944c6b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>1</p><?php 
};
Parsed::$templates['slot_default?id=61e316694583a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default?id=61e31669459fc'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>slot1<?php 
};
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['slot_default?id=61e3166945c3b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','data',])));
      
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);

    $comp0->render($data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e3166946925'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61e3166946848'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','comp1','slots','data',])));
      
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e3166946925', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e3166946ec0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e3166946e27'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
      $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e3166946ec0', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  
};
Parsed::$templates['slot_default?id=61e3166946d40'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','comp1','slots','data',])));
      
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e3166946e27', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    }  
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','slots','slot','data','comp0',])));
      foreach ([2] as $a) { ?><div class="comp_slot_default">
    <span><?php 
    foreach ([1,2] as $a) {
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e316694583a', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    } ?></span>
    <div class=""><?php 
    foreach ([1,2] as $a) {
    if (!empty($slots["slot1"])) {
    foreach ($slots['slot1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e31669459fc', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e3166945c3b', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e3166946848', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <?php 
    if (!empty($slots["slot3"])) {
    foreach ($slots['slot3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e3166946d40', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php }  
};
Parsed::$templates['slot_default?id=61e3166948ef8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61e31669493d9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61e31669492fc'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e31669493d9', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61e316694991d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
      $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);  
};
Parsed::$templates['slot_default?id=61e3166949834'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn4"])) {
    foreach ($slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e316694991d', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61e3166949e19'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
      $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e3166949d3d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
      
    if (!empty($slots["sn5"])) {
    foreach ($slots['sn5'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e3166949e19', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  
};
Parsed::$templates['slot_default?id=61e316694a314'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
      
    if (!empty($slots["sn7"])) {
    foreach ($slots['sn7'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e316694a22c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
      
    if (!empty($slots["sn6"])) {
    foreach ($slots['sn6'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e316694a314', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }  
};
Parsed::$templates['slot_default?id=61e316694a7e8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
      $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e316694a722'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="x">
        <?php 
    if (!empty($slots["sn8"])) {
    foreach ($slots['sn8'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e316694a7e8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
    </div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e316694aaec'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61e316694ad29'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
        djdh
        <?php 
};
Parsed::$templates['slot_default?id=61e316694ae86'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
      $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e316694ac26'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','slots','slot','data','comp0',])));
      
    foreach ([1] as $a) {
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e316694ad29', []);

    $comp0->setSlots($slots);
    $comp0->render($data);$comp0 = Parsed::template('slot_default?id=61e316694ae86', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e316694b161'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/cns'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0','comp1',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e3166948ef8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn1"])) {
    foreach ($slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e31669492fc', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn3"])) {
    foreach ($slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61e3166949834', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e3166949d3d', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e316694a22c', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e316694a722', ['class' => 'x']));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e316694aaec', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e316694ac26', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e316694b161', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  
};
Parsed::$templates['comp/cns_slot_sn?id=61e316694c929'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['i',])));
      for ($i=0;$i<2;$i++) { ?><span class="x"></span><?php }  
};
Parsed::$templates['comp/cns_slot_sn1?id=61e316694cb3a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/cns_slot_sn3?id=61e316694cc2c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/cns_slot_sn5?id=61e316694cd14'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
      $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);  
};
Parsed::$templates['comp/cns_slot_sn8?id=61e316694ce58'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/cns_slot_sn9?id=61e316694cf33'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['array','array_map','true','false','a','comp0','data','comp1','slots',])));
     ?><!DOCTYPE html>
<html>
<body><?php $array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
 foreach ($array as $a) { ?><div class="x">
    <span></span>
</div><?php } ?>

-----


<?php foreach ($array as $a) { ?><div class="x">
    <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?>
</div><?php } ?>

-----


<div class="x">
    <?php 
    foreach ($array as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?>
</div>

-----


<?php 
    foreach ($array as $a) {$comp0 = Parsed::template('comp/simple', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/simple_slot_default?id=61e3166942090', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    } ?>

-----



<?php $comp0 = Parsed::template('comp/c', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/csf', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/csf_slot_default?id=61e3166944aab', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/csf', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/csf_slot_default?id=61e3166944c6b', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/csdf', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/cns', []);
$comp1 = $comp0->addSlot('sn', Parsed::template('comp/cns_slot_sn?id=61e316694c929', ['class' => 'x']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn1', Parsed::template('comp/cns_slot_sn1?id=61e316694cb3a', ['class' => 'y']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn3', Parsed::template('comp/cns_slot_sn3?id=61e316694cc2c', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn5', Parsed::template('comp/cns_slot_sn5?id=61e316694cd14', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn8', Parsed::template('comp/cns_slot_sn8?id=61e316694ce58', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/cns_slot_sn9?id=61e316694cf33', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php if ($false) { ?><div></div><?php }  elseif ($false) { ?><div></div><?php }  else { ?><else></else><?php } ?>

-----


<?php 
    if ($true) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php 
    if ($false) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php foreach ([1, 2] as $a) {  if ($a == 2) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----


2<?php if ($false) {  foreach ([1, 2] as $a) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----</body></html><?php 
};