<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/simple_slot_default?id=61fede1b18e97'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>
    comp/simple
<?php 
};
Parsed::$templates['comp/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this',]));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);
    }  foreach ([1,2] as $a) { ?><div class="comp/composed">
    <?php $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data); ?>
    comp/simple
    <span>
        <?php 
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);
    } ?>
    </span>
</div><?php }  
};
Parsed::$templates['comp/csf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['i','this','slot',]));
     ?><div class="comp_slot">
    <?php 
    for ($i=0;$i<2;$i++) {
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    } ?>
</div><?php 
};
Parsed::$templates['comp/csf_slot_default?id=61fede1b192cf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>x2<?php 
};
Parsed::$templates['comp/csf_slot_default?id=61fede1b1930f'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>1</p><?php 
};
Parsed::$templates['slot_default?id=61fede1b1950f'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default?id=61fede1b1956a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>slot1<?php 
};
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['slot_default?id=61fede1b195b9'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this',]));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/comp_slot', []);

    $this->comp[0]->render($this->data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b1979e'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61fede1b19788'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this','slots',]));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b1979e', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19825'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>bar<?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19817'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
      $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19825', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  
};
Parsed::$templates['slot_default?id=61fede1b19800'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this','slots',]));
      
    foreach ([1,2] as $a) {$this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19817', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }  
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this','slot','_attrs','slots',]));
      foreach ([2] as $a) { ?><div class="comp_slot_default">
    <span><?php 
    foreach ([1,2] as $a) {
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b1950f", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }
    } ?></span>
    <div class=""><?php 
    foreach ([1,2] as $a) {
    if (!empty($this->slots["slot1"])) {
    foreach ($this->slots['slot1'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b1956a", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }
    } ?></div>
    <div><?php 
    if (!empty($this->slots["slot2"])) {
    foreach ($this->slots['slot2'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b195b9", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?></div>
    <div><?php 
    if (!empty($this->slots["slot2"])) {
    foreach ($this->slots['slot2'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19788", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?></div>
    <?php 
    if (!empty($this->slots["slot3"])) {
    foreach ($this->slots['slot3'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19800", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?>
</div><?php }  
};
Parsed::$templates['slot_default?id=61fede1b19ae3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
     ?><span><?php 
    if (!empty($this->slots["sn"])) {
    foreach ($this->slots['sn'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61fede1b19b5c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61fede1b19b4a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
     ?><span><?php 
    if (!empty($this->slots["sn2"])) {
    foreach ($this->slots['sn2'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19b5c", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61fede1b19bdd'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['slot_default?id=61fede1b19bc8'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
     ?><span><?php 
    if (!empty($this->slots["sn4"])) {
    foreach ($this->slots['sn4'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19bdd", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61fede1b19c64'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19c50'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
      
    if (!empty($this->slots["sn5"])) {
    foreach ($this->slots['sn5'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19c64", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }  
};
Parsed::$templates['slot_default?id=61fede1b19ce1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
      
    if (!empty($this->slots["sn7"])) {
    foreach ($this->slots['sn7'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19cce'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
      
    if (!empty($this->slots["sn6"])) {
    foreach ($this->slots['sn6'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19ce1", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }  
};
Parsed::$templates['slot_default?id=61fede1b19d6c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19d4e'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
     ?><div class="x">
        <?php 
    if (!empty($this->slots["sn8"])) {
    foreach ($this->slots['sn8'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19d6c", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?>
    </div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19de3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61fede1b19e25'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>
        djdh
        <?php 
};
Parsed::$templates['slot_default?id=61fede1b19e43'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19e0c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this','slot','_attrs','slots',]));
      
    foreach ([1] as $a) {
    if (!empty($this->slots["sn9"])) {
    foreach ($this->slots['sn9'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19e25", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19e43", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b19e9b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/cns'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19ae3", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($this->slots["sn1"])) {
    foreach ($this->slots['sn1'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19b4a", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($this->slots["sn3"])) {
    foreach ($this->slots['sn3'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b19bc8", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?>
</div><?php $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19c50', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19cce', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19d4e', ['class' => 'x']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19de3', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19e0c', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b19e9b', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/cns_slot_sn?id=61fede1b1a1a4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['i',]));
      for ($i=0;$i<2;$i++) { ?><span class="x"></span><?php }  
};
Parsed::$templates['comp/cns_slot_sn1?id=61fede1b1a1e1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/cns_slot_sn3?id=61fede1b1a207'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/cns_slot_sn5?id=61fede1b1a22a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/cns_slot_sn8?id=61fede1b1a259'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/cns_slot_sn9?id=61fede1b1a27a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['array','array_map','true','false','a','this','slots',]));
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

    $this->comp[0]->render($this->data); ?>
</div><?php } ?>

-----


<div class="x">
    <?php 
    foreach ($array as $a) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);
    } ?>
</div>

-----


<?php 
    foreach ($array as $a) {$this->comp[0] = Parsed::template('comp/simple', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/simple_slot_default?id=61fede1b18e97', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);
    } ?>

-----



<?php $this->comp[0] = Parsed::template('comp/c', []);

    $this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template('comp/csf', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/csf_slot_default?id=61fede1b192cf', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template('comp/csf', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/csf_slot_default?id=61fede1b1930f', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('comp/csdf', []);

    $this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template('comp/cns', []);
$this->comp[1] = $this->comp[0]->addSlot('sn', Parsed::template('comp/cns_slot_sn?id=61fede1b1a1a4', ['class' => 'x']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn1', Parsed::template('comp/cns_slot_sn1?id=61fede1b1a1e1', ['class' => 'y']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn3', Parsed::template('comp/cns_slot_sn3?id=61fede1b1a207', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn5', Parsed::template('comp/cns_slot_sn5?id=61fede1b1a22a', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn8', Parsed::template('comp/cns_slot_sn8?id=61fede1b1a259', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('sn9', Parsed::template('comp/cns_slot_sn9?id=61fede1b1a27a', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----


<?php if ($false) { ?><div></div><?php }  elseif ($false) { ?><div></div><?php }  else { ?><else></else><?php } ?>

-----


<?php 
    if ($true) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php 
    if ($false) {$this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php foreach ([1, 2] as $a) {  if ($a == 2) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----


2<?php if ($false) {  foreach ([1, 2] as $a) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----</body></html><?php 
};