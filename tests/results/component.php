<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/simple'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp/simple">
    comp/simple
</div>

 <?php };
Parsed::$templates['comp/composed'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?>

<div class="comp/composed">
    
<?php $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?>
    comp/simple
    <span>
        
<?php $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?></span>
</div>

 <?php };
Parsed::$templates['./temp/component'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("comp/composed", []);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };