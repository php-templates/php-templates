<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['components/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['_attrs','k','v','slots','slot','data',])));
     ?><div <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></div><?php 
};
Parsed::$templates['components/ns'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','this','slot','data',])));
     ?>comp/ns<?php
    $comp0 = Parsed::template('components/c', ['class' => 'compc']);
    foreach ($this->slots["default"] ?? [] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    $comp0->render($data); ?><?php 
};
Parsed::$templates['slotOf_61bce2dced422_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>ns<?php 
};
Parsed::$templates['slotOf_61bce2dceda7d_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>ns<?php 
};
Parsed::$templates['slotOf_61bce2dced8fe_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','data',])));
     ?><div class="plainSlot">
<?php
    $comp0 = Parsed::template('components/ns', ['class' => 'compns ']);$comp1 = $comp0->addSlot('default', Parsed::template('slotOf_61bce2dceda7d_slot_default', []));

    $comp0->render($data); ?>
</div><?php 
};
Parsed::$templates['components/nns'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','this','slot','data',])));
     ?>comp/nns<?php
    $comp0 = Parsed::template('components/c', ['class' => 'comp']);$comp1 = $comp0->addSlot('default', Parsed::template('components/c', ['class' => 'comp']));

    foreach ($this->slots["default"] ?? [] as $slot) {
    $comp1->addSlot('default', $slot);
    }
    $comp0->render($data); ?><?php 
};
Parsed::$templates['slotOf_61bce2dcef020_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>nns<?php 
};
Parsed::$templates['cases'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','comp2','data',])));
     ?><?php
    $comp0 = Parsed::template('components/c', ['class' => 'onroot']);$comp1 = $comp0->addSlot('default', Parsed::template('components/ns', ['class' => 'compns ']));
$comp2 = $comp1->addSlot('default', Parsed::template('slotOf_61bce2dced422_slot_default', []));

    $comp0->render($data); ?>ar trebui sa rezulte<div>comp/ns<div>ns</div></div><?php
    $comp0 = Parsed::template('components/c', ['class' => 'onroot']);$comp1 = $comp0->addSlot('default', Parsed::template('slotOf_61bce2dced8fe_slot_default', ['class' => 'plainSlot']));

    $comp0->render($data); ?>ar trebui sa rezulte<div><div class="plainSlot">comp/ns<div class="compns">ns</div></div></div><?php
    $comp0 = Parsed::template('components/c', ['class' => 'onroot']);$comp1 = $comp0->addSlot('default', Parsed::template('components/nns', ['class' => 'compnns ']));
$comp2 = $comp1->addSlot('default', Parsed::template('slotOf_61bce2dcef020_slot_default', []));

    $comp0->render($data); ?>ar trebui sa rezolte<div onroot>comp/nns<div><div>nns</div></div></div><?php 
};
Parsed::template('cases', $data)->render(); ?>