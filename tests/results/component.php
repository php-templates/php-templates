<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/composed'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data); ?><div class="comp/composed">
    <?php $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data); ?>
    comp/simple
    <span>
        <?php $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data); ?>
    </span>
</div><?php 
};
Parsed::$templates['./cases/component'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
     ?><!DOCTYPE html>
<html>
<body><div class="comp/simple">     comp/simple </div>

-----



<?php $this->comp[0] = Parsed::template('comp/composed', []);

    $this->comp[0]->render($data); ?>

-----</body></html><?php 
};