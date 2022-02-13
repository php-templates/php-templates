<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['a1?slot=16'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a11></a11> <?php 
};
Parsed::$templates['a2?slot=17'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a21></a21> <?php 
};
Parsed::$templates['block/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <a>
    
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("a1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("a1", Parsed::template("a1?slot=19", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
    
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("a2")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("a2", Parsed::template("a2?slot=20", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
</a> <?php 
};
Parsed::$templates['block/a?slot=a2&id=18'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a22>a22</a22> <?php 
};
Parsed::$templates['a1?slot=19'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a11></a11> <?php 
};
Parsed::$templates['a2?slot=20'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a21></a21> <?php 
};
Parsed::$templates['block/a?slot=a2&id=21'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a22>a22</a22> <?php 
};
Parsed::$templates['b1?slot=22'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11></b11> <?php 
};
Parsed::$templates['b12?slot=23'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b121></b121> <?php 
};
Parsed::$templates['b122?slot=25'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b1221></b1221> <?php 
};
Parsed::$templates['b12?slot=24'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <n>
            
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("b122")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("b122?slot=25", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
            </n> <?php 
};
Parsed::$templates['b2?slot=26'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b21></b21> <?php 
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <b>
    
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=22", ['_index' => '1'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("***block", ['_index' => '2'])->withName("b12")->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=23", ['_index' => '1'])->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=24", ['_index' => '2'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
</b><?php ;$this->comp[0] = Parsed::template("***block", [])->withName("b2")->setSlots($this->slots);$this->comp[1] = $this->comp[0]->addSlot("b2", Parsed::template("b2?slot=26", ['_index' => '1'])->setSlots($this->slots));$this->comp[0]->render($this->data);?> <?php 
};
Parsed::$templates['block/b?slot=b1&id=27'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b12></b12> <?php 
};
Parsed::$templates['block/b?slot=b12&id=28'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b122></b122> <?php 
};
Parsed::$templates['block/b?slot=b122&id=29'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b1222></b1222> <?php 
};
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot">
    <span>
<?php  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  ?></span>
</div> <?php 
};
Parsed::$templates['b1?slot=30'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11>123</b11> <?php 
};
Parsed::$templates['b1?slot=32'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11>123</b11> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=31'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <div>
        
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=32", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
    </div> <?php 
};
Parsed::$templates['b1?slot=33'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k',]));
     ?> <b11><?php echo htmlspecialchars($k); ?></b11> <?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div> <?php 
};
Parsed::$templates['./cases/block'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','a','k',]));
     ?> <!DOCTYPE html>
<html>
<body>
<?php ;
$this->comp[0] = Parsed::template("block/a", []);
$this->comp[1] = $this->comp[0]->addSlot("a2", Parsed::template("block/a?slot=a2&id=18", ['_index' => '99']));
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("block/a", []); foreach ([1,2] as $a) { 
$this->comp[1] = $this->comp[0]->addSlot("a2", Parsed::template("block/a?slot=a2&id=21", ['_index' => '99'])); } 
$this->comp[0]->render($this->data);
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("block/b", []);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("block/b?slot=b1&id=27", ['_index' => '2.5']));
$this->comp[1] = $this->comp[0]->addSlot("b12", Parsed::template("block/b?slot=b12&id=28", ['_index' => '2.5']));
$this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("block/b?slot=b122&id=29", ['_index' => '99']));
$this->comp[0]->render($this->data);
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("***block", [])->withName("b1")->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=30", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=31", []));
$this->comp[0]->render($this->data);
 ?>

-----






<?php ; foreach ([1,2] as $k) { 
$this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=33", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data); } 
 ?>

-----




<?php ; foreach ([1,2] as $k) { 
$this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("comp/simple", ['_index' => '1']));
$this->comp[0]->render($this->data); } 
 ?>

-----</body></html> <?php 
};