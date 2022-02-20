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
Parsed::$templates['./cases/12'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['array','array_map','true','false','this',]));
     ?> <html><body><?php 
$array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
?>
<?php ;
if ($true) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
} 
elseif ($true) { 
 ?><elseif></elseif>
<?php ;
} 
 ?>

-----</body></html> <?php 
};