<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['block_a1_slot?id=61e6f9997196e'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><a11></a11><?php 
};
Parsed::$templates['a1?id=61e6f99971903'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['a1'] = Parsed::raw('a1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['a1'])) {
                usort($this->slots['a1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['a1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['a1']->addSlot('a1', Parsed::template('block_a1_slot?id=61e6f9997196e', ['_index' => '1']))->setSlots($slots);
$this->block['a1']->render($data);  
};
Parsed::$templates['block_a2_slot?id=61e6f99971c1c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><a21></a21><?php 
};
Parsed::$templates['a2?id=61e6f99971be9'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['a2'] = Parsed::raw('a2', function($data, $slots) {
            extract($data);
            if (isset($this->slots['a2'])) {
                usort($this->slots['a2'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['a2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['a2']->addSlot('a2', Parsed::template('block_a2_slot?id=61e6f99971c1c', ['_index' => '1']))->setSlots($slots);
$this->block['a2']->render($data);  
};
Parsed::$templates['block/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><a>
    <?php Parsed::template('a1?id=61e6f99971903', [])->setSlots($slots)->render($this->data);  Parsed::template('a2?id=61e6f99971be9', [])->setSlots($slots)->render($this->data); ?></a><?php 
};
Parsed::$templates['block/a_slot_a2?id=61e6f999720c1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><a22>a22</a22><?php 
};
Parsed::$templates['block/a_slot_a2?id=61e6f9997227b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a',]));
      foreach ([1,2] as $a) { ?><a22>a22</a22><?php }  
};
Parsed::$templates['block_b1_slot?id=61e6f99972f4c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot?id=61e6f999731fd'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot?id=61e6f9997341d'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61e6f999733e8'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b122'] = Parsed::raw('b122', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b122'])) {
                usort($this->slots['b122'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b122'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b122']->addSlot('b122', Parsed::template('block_b122_slot?id=61e6f9997341d', ['_index' => '1']))->setSlots($slots);
$this->block['b122']->render($data);  
};
Parsed::$templates['block_b12_slot?id=61e6f9997336d'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><n><?php Parsed::template('b122?id=61e6f999733e8', [])->setSlots($slots)->render($this->data); ?></n><?php 
};
Parsed::$templates['b12?id=61e6f999731bf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b12'] = Parsed::raw('b12', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b12'])) {
                usort($this->slots['b12'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b12'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61e6f999731fd', ['_index' => '1']))->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61e6f9997336d', ['_index' => '2']))->setSlots($slots);
$this->block['b12']->render($data);  
};
Parsed::$templates['b1?id=61e6f99972e8a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e6f99972f4c', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('b12?id=61e6f999731bf', ['_index' => '2']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['block_b2_slot?id=61e6f999738ff'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61e6f999738c9'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b2'] = Parsed::raw('b2', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b2'])) {
                usort($this->slots['b2'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b2']->addSlot('b2', Parsed::template('block_b2_slot?id=61e6f999738ff', ['_index' => '1']))->setSlots($slots);
$this->block['b2']->render($data);  
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><b>
    <?php Parsed::template('b1?id=61e6f99972e8a', [])->setSlots($slots)->render($this->data); ?></b><?php Parsed::template('b2?id=61e6f999738c9', [])->setSlots($slots)->render($this->data);  
};
Parsed::$templates['block/b_slot_b1?id=61e6f9997414c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12?id=61e6f9997429f'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122?id=61e6f999743a4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b1222></b1222><?php 
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
Parsed::$templates['block_b1_slot?id=61e6f99975844'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61e6f99975802'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e6f99975844', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e6f99975772'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
      Parsed::template('b1?id=61e6f99975802', [])->setSlots($slots)->render($this->data);  
};
Parsed::$templates['block_b1_slot?id=61e6f99975d75'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61e6f99975d3c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e6f99975d75', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e6f99975c75'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><div>
        <?php Parsed::template('b1?id=61e6f99975d3c', [])->setSlots($slots)->render($this->data); ?></div><?php 
};
Parsed::$templates['block_b1_slot?id=61e6f9997610c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k',]));
     ?><b11><?php echo htmlspecialchars($k); ?></b11><?php 
};
Parsed::$templates['b1?id=61e6f999760b2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k','this','data','slots','a','b','i1','i2','slot',]));
      
    foreach ([1,2] as $k) {$this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e6f9997610c', ['k' => $k, '_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);
    }  
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['b1?id=61e6f9997632b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k','this','data','slots','a','b','i1','i2','slot',]));
      
    foreach ([1,2] as $k) {$this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('comp/simple', ['k' => $k, '_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);
    }  
};
Parsed::$templates['./cases/block'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
     ?><!DOCTYPE html>
<html><body><?php $this->comp[0] = Parsed::template('block/a', []);
$this->comp[1] = $this->comp[0]->addSlot('a2', Parsed::template('block/a_slot_a2?id=61e6f999720c1', ['_index' => '99']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template('block/a', []);
$this->comp[1] = $this->comp[0]->addSlot('a2', Parsed::template('block/a_slot_a2?id=61e6f9997227b', ['_index' => '99']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('block/b', []);
$this->comp[1] = $this->comp[0]->addSlot('b1', Parsed::template('block/b_slot_b1?id=61e6f9997414c', ['_index' => '2.5']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('b12', Parsed::template('block/b_slot_b12?id=61e6f9997429f', ['_index' => '2.5']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('b122', Parsed::template('block/b_slot_b122?id=61e6f999743a4', ['_index' => '99']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e6f99975772', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e6f99975c75', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----





<?php Parsed::template('b1?id=61e6f999760b2', [])->setSlots($slots)->render($this->data); ?>

-----



<?php Parsed::template('b1?id=61e6f9997632b', [])->setSlots($slots)->render($this->data); ?>

-----</body></html><?php 
};