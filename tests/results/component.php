<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div> <?php 
};
Parsed::$templates['comp/composed'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <?php $this->comp[0] = Parsed::template("comp/simple", []);$this->comp[0]->render($this->data); ?><div class="comp/composed">
    
<?php $this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data); ?>
    comp/simple
    <span>
        
<?php $this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data); ?>
    </span>
</div> <?php 
};
Parsed::$templates['./cases/component'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html>
<body>
<?php $this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data); ?>

-----




<?php $this->comp[0] = Parsed::template("comp/composed", []);
$this->comp[0]->render($this->data); ?>

-----</body></html> <?php 
};