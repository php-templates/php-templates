<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/composed'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><div class="comp/composed">
    <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?>
    comp/simple
    <span>
        <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?></span>
</div><?php 
};
Parsed::$templates['./cases/component'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><!DOCTYPE html>
<html><body><div class="comp/simple">     comp/simple </div>

-----



<?php $comp0 = Parsed::template('comp/composed', []);

    $comp0->render($data); ?>

-----</body></html><?php 
};