<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_a1_slot?id=61d9d558da9ef'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a11></a11><?php 
};
Parsed::$templates['a1?id=61d9d558da990'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['a1'] = Parsed::raw('a1', function($data, $slots) {
            extract($data);
            if (isset($slots['a1'])) {
                usort($slots['a1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['a1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['a1']->addSlot('a1', Parsed::template('block_a1_slot?id=61d9d558da9ef', ['_index' => '0']))->setSlots($slots);
$this->block['a1']->render($data);  
};
Parsed::$templates['block_a2_slot?id=61d9d558dad7c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a21></a21><?php 
};
Parsed::$templates['a2?id=61d9d558dad39'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['a2'] = Parsed::raw('a2', function($data, $slots) {
            extract($data);
            if (isset($slots['a2'])) {
                usort($slots['a2'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['a2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['a2']->addSlot('a2', Parsed::template('block_a2_slot?id=61d9d558dad7c', ['_index' => '0']))->setSlots($slots);
$this->block['a2']->render($data);  
};
Parsed::$templates['block/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><a>
    <?php Parsed::template('a1?id=61d9d558da990', [])->setSlots($slots)->render($data);  Parsed::template('a2?id=61d9d558dad39', [])->setSlots($slots)->render($data); ?></a><?php 
};
Parsed::$templates['block/a_slot_a2?id=61d9d558db291'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a22>a22</a22><?php 
};
Parsed::$templates['block/a_slot_a2?id=61d9d558db4c7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a',])));
      foreach ([1,2] as $a) { ?><a22>a22</a22><?php }  
};
Parsed::$templates['block_b1_slot?id=61d9d558dc213'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot?id=61d9d558dc544'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot?id=61d9d558dc974'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61d9d558dc905'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b122'] = Parsed::raw('b122', function($data, $slots) {
            extract($data);
            if (isset($slots['b122'])) {
                usort($slots['b122'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b122'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b122']->addSlot('b122', Parsed::template('block_b122_slot?id=61d9d558dc974', ['_index' => '0']))->setSlots($slots);
$this->block['b122']->render($data);  
};
Parsed::$templates['block_b12_slot?id=61d9d558dc7e5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n><?php Parsed::template('b122?id=61d9d558dc905', [])->setSlots($slots)->render($data); ?></n><?php 
};
Parsed::$templates['b12?id=61d9d558dc4d6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b12'] = Parsed::raw('b12', function($data, $slots) {
            extract($data);
            if (isset($slots['b12'])) {
                usort($slots['b12'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b12'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61d9d558dc544', ['_index' => '0']))->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61d9d558dc7e5', ['_index' => '1']))->setSlots($slots);
$this->block['b12']->render($data);  
};
Parsed::$templates['b1?id=61d9d558dc196'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($slots['b1'])) {
                usort($slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61d9d558dc213', ['_index' => '0']))->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('b12?id=61d9d558dc4d6', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['block_b2_slot?id=61d9d558dcf1b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61d9d558dcee0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b2'] = Parsed::raw('b2', function($data, $slots) {
            extract($data);
            if (isset($slots['b2'])) {
                usort($slots['b2'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b2']->addSlot('b2', Parsed::template('block_b2_slot?id=61d9d558dcf1b', ['_index' => '0']))->setSlots($slots);
$this->block['b2']->render($data);  
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><b>
    <?php Parsed::template('b1?id=61d9d558dc196', [])->setSlots($slots)->render($data); ?></b><?php Parsed::template('b2?id=61d9d558dcee0', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['block/b_slot_b1?id=61d9d558dd6d7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12?id=61d9d558dd827'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122?id=61d9d558dd9b7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
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
Parsed::$templates['block_b1_slot?id=61d9d558debaa'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61d9d558deb69'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($slots['b1'])) {
                usort($slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61d9d558debaa', ['_index' => '0']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d9d558deafc'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
      Parsed::template('b1?id=61d9d558deb69', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['block_b1_slot?id=61d9d558df0a7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61d9d558df06c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($slots['b1'])) {
                usort($slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61d9d558df0a7', ['_index' => '0']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d9d558defdf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><div>
        <?php Parsed::template('b1?id=61d9d558df06c', [])->setSlots($slots)->render($data); ?></div><?php 
};
Parsed::$templates['block_b1_slot?id=61d9d558df498'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k',])));
     ?><b11><?php echo htmlspecialchars($k); ?></b11><?php 
};
Parsed::$templates['b1?id=61d9d558df42e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k','this','data','slots','a','b','i1','i2','slot',])));
      
    foreach ([1,2] as $k) {$this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($slots['b1'])) {
                usort($slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61d9d558df498', ['k' => $k, '_index' => '0']))->setSlots($slots);
$this->block['b1']->render($data);
    }  
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['b1?id=61d9d558df73f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k','this','data','slots','a','b','i1','i2','slot',])));
      
    foreach ([1,2] as $k) {$this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($slots['b1'])) {
                usort($slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('comp/simple', ['k' => $k, '_index' => '0']))->setSlots($slots);
$this->block['b1']->render($data);
    }  
};
Parsed::$templates['./cases/block'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html><body><?php $comp0 = Parsed::template('block/a', []);
$comp1 = $comp0->addSlot('a2', Parsed::template('block/a_slot_a2?id=61d9d558db291', ['_index' => '99']));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('block/a', []);
$comp1 = $comp0->addSlot('a2', Parsed::template('block/a_slot_a2?id=61d9d558db4c7', ['_index' => '99']));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('block/b', []);
$comp1 = $comp0->addSlot('b1', Parsed::template('block/b_slot_b1?id=61d9d558dd6d7', ['_index' => '1.5']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b12', Parsed::template('block/b_slot_b12?id=61d9d558dd827', ['_index' => '1.5']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b122', Parsed::template('block/b_slot_b122?id=61d9d558dd9b7', ['_index' => '99']));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d9d558deafc', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d9d558defdf', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----





<?php Parsed::template('b1?id=61d9d558df42e', [])->setSlots($slots)->render($data); ?>

-----



<?php Parsed::template('b1?id=61d9d558df73f', [])->setSlots($slots)->render($data); ?>

-----</body></html><?php 
};