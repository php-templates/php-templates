<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/simple_slot_default?id=61e31e44bbbe0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
    comp/simple
<?php 
};
Parsed::$templates['comp/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','this','data',])));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);
    }  foreach ([1,2] as $a) { ?><div class="comp/composed">
    <?php $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data); ?>
    comp/simple
    <span>
        <?php 
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);
    } ?>
    </span>
</div><?php }  
};
Parsed::$templates['comp/csf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['i','this','slot','data',])));
     ?><div class="comp_slot">
    <?php 
    for ($i=0;$i<2;$i++) {
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    } ?>
</div><?php 
};
Parsed::$templates['comp/csf_slot_default?id=61e31e44bdd59'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>x2<?php 
};
Parsed::$templates['comp/csf_slot_default?id=61e31e44bdeb7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>1</p><?php 
};
Parsed::$templates['slot_default?id=61e31e44be7e4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default?id=61e31e44be9c9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>slot1<?php 
};
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data',])));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['slot_default?id=61e31e44bebbf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','this','data',])));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/comp_slot', []);

    $this->comp[0]->render($data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44bf591'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61e31e44bf513'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','this','slots','data',])));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44bf591', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44bf8bf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44bf85c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
      $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44bf8bf', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  
};
Parsed::$templates['slot_default?id=61e31e44bf7c8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','this','slots','data',])));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44bf85c', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','this','slot','data','slots',])));
      foreach ([2] as $a) { ?><div class="comp_slot_default">
    <span><?php 
    foreach ([1,2] as $a) {
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44be7e4', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }
    } ?></span>
    <div class=""><?php 
    foreach ([1,2] as $a) {
    if (!empty($this->slots["slot1"])) {
    foreach ($this->slots['slot1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44be9c9', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }
    } ?></div>
    <div><?php 
    if (!empty($this->slots["slot2"])) {
    foreach ($this->slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44bebbf', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?></div>
    <div><?php 
    if (!empty($this->slots["slot2"])) {
    foreach ($this->slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44bf513', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?></div>
    <?php 
    if (!empty($this->slots["slot3"])) {
    foreach ($this->slots['slot3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44bf7c8', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?>
</div><?php }  
};
Parsed::$templates['slot_default?id=61e31e44c07b4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data',])));
     ?><span><?php 
    if (!empty($this->slots["sn"])) {
    foreach ($this->slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61e31e44c0a71'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61e31e44c09fb'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
     ?><span><?php 
    if (!empty($this->slots["sn2"])) {
    foreach ($this->slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c0a71', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61e31e44c0d67'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['slot_default?id=61e31e44c0ce4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
     ?><span><?php 
    if (!empty($this->slots["sn4"])) {
    foreach ($this->slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c0d67', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61e31e44c13c1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44c133c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
      
    if (!empty($this->slots["sn5"])) {
    foreach ($this->slots['sn5'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c13c1', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
};
Parsed::$templates['slot_default?id=61e31e44c16ef'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data',])));
      
    if (!empty($this->slots["sn7"])) {
    foreach ($this->slots['sn7'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44c1679'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
      
    if (!empty($this->slots["sn6"])) {
    foreach ($this->slots['sn6'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c16ef', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
};
Parsed::$templates['slot_default?id=61e31e44c1d65'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44c1b3d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
     ?><div class="x">
        <?php 
    if (!empty($this->slots["sn8"])) {
    foreach ($this->slots['sn8'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c1d65', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?>
    </div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44c2231'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61e31e44c24be'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
        djdh
        <?php 
};
Parsed::$templates['slot_default?id=61e31e44c25e8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44c23b9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','this','slot','data','slots',])));
      
    foreach ([1] as $a) {
    if (!empty($this->slots["sn9"])) {
    foreach ($this->slots['sn9'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c24be', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);$this->comp[0] = Parsed::template('slot_default?id=61e31e44c25e8', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e44c293e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/cns'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c07b4', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($this->slots["sn1"])) {
    foreach ($this->slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c09fb', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($this->slots["sn3"])) {
    foreach ($this->slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e31e44c0ce4', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?>
</div><?php $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44c133c', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44c1679', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44c1b3d', ['class' => 'x']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44c2231', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44c23b9', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e44c293e', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/cns_slot_sn?id=61e31e44c45fc'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['i',])));
      for ($i=0;$i<2;$i++) { ?><span class="x"></span><?php }  
};
Parsed::$templates['comp/cns_slot_sn1?id=61e31e44c481c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/cns_slot_sn3?id=61e31e44c4981'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/cns_slot_sn5?id=61e31e44c4af1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/cns_slot_sn8?id=61e31e44c4cd3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/cns_slot_sn9?id=61e31e44c4e2b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['array','array_map','true','false','a','this','data','slots',])));
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
    <?php $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data); ?>
</div><?php } ?>

-----


<div class="x">
    <?php 
    foreach ($array as $a) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);
    } ?>
</div>

-----


<?php 
    foreach ($array as $a) {$this->comp[0] = Parsed::template('comp/simple', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/simple_slot_default?id=61e31e44bbbe0', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);
    } ?>

-----



<?php $this->comp[0] = Parsed::template('comp/c', []);

    $this->comp[0]->render($data); ?>

-----


<?php $this->comp[0] = Parsed::template('comp/csf', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/csf_slot_default?id=61e31e44bdd59', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----


<?php $this->comp[0] = Parsed::template('comp/csf', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/csf_slot_default?id=61e31e44bdeb7', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----



<?php $this->comp[0] = Parsed::template('comp/csdf', []);

    $this->comp[0]->render($data); ?>

-----


<?php $this->comp[0] = Parsed::template('comp/cns', []);
$this->comp[1] = $this->comp[0]->addSlot('sn', Parsed::template('comp/cns_slot_sn?id=61e31e44c45fc', ['class' => 'x']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn1', Parsed::template('comp/cns_slot_sn1?id=61e31e44c481c', ['class' => 'y']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn3', Parsed::template('comp/cns_slot_sn3?id=61e31e44c4981', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn5', Parsed::template('comp/cns_slot_sn5?id=61e31e44c4af1', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn8', Parsed::template('comp/cns_slot_sn8?id=61e31e44c4cd3', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn9', Parsed::template('comp/cns_slot_sn9?id=61e31e44c4e2b', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----


<?php if ($false) { ?><div></div><?php }  elseif ($false) { ?><div></div><?php }  else { ?><else></else><?php } ?>

-----


<?php 
    if ($true) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php 
    if ($false) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php foreach ([1, 2] as $a) {  if ($a == 2) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----


2<?php if ($false) {  foreach ([1, 2] as $a) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----</body></html><?php 
};