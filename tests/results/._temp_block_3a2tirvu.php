<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['a1?slot=33'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a11></a11> <?php };
Parsed::$templates['a2?slot=34'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a21></a21> <?php };
Parsed::$templates['block/a'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a>
    
<?php $this->comp[0] = Parsed::template("***block", [])->withName("a1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("a1", Parsed::template("a1?slot=36", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData);  $this->comp[0] = Parsed::template("***block", [])->withName("a2")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("a2", Parsed::template("a2?slot=37", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>
</a>

 <?php };
Parsed::$templates['block/a?slot=a2&id=35'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a22>a22</a22> <?php };
Parsed::$templates['a1?slot=36'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a11></a11> <?php };
Parsed::$templates['a2?slot=37'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a21></a21> <?php };
Parsed::$templates['block/a?slot=a2&id=38'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a22>a22</a22> <?php };
Parsed::$templates['b1?slot=39'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b11></b11> <?php };
Parsed::$templates['b12?slot=40'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b121></b121> <?php };
Parsed::$templates['b122?slot=42'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b1221></b1221> <?php };
Parsed::$templates['b12?slot=41'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <n>
            
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b122")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("b122?slot=42", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>
            </n> <?php };
Parsed::$templates['b2?slot=43'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b21></b21> <?php };
Parsed::$templates['block/b'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b>
    
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=39", ['_index' => 1])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("***block", ['_index' => '2'])->withName("b12")->setSlots($this->slots));  $this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=40", ['_index' => 1])->setSlots($this->slots));  $this->comp[2] = $this->comp[1]->addSlot("b12", Parsed::template("b12?slot=41", ['_index' => 2])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>
</b>


<?php $this->comp[0] = Parsed::template("***block", [])->withName("b2")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b2", Parsed::template("b2?slot=43", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData);  };
Parsed::$templates['block/b?slot=b1&id=44'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b12></b12> <?php };
Parsed::$templates['block/b?slot=b12&id=45'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b122></b122> <?php };
Parsed::$templates['block/b?slot=b122&id=46'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b1222></b1222> <?php };
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></span>
</div>

 <?php };
Parsed::$templates['b1?slot=47'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b11>123</b11> <?php };
Parsed::$templates['b1?slot=49'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b11>123</b11> <?php };
Parsed::$templates['comp/comp_slot?slot=default&id=48'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div>
        
<?php $this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=49", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>
    </div> <?php };
Parsed::$templates['b1?slot=50'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b11><?php echo htmlspecialchars($k); ?></b11> <?php };
Parsed::$templates['comp/simple'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp/simple">
    comp/simple
</div>

 <?php };
Parsed::$templates['./temp/block'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("block/a", []);  $this->comp[1] = $this->comp[0]->addSlot("a2", Parsed::template("block/a?slot=a2&id=35", ['slot' => 'a2', '_index' => '99'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("block/a", []);  foreach ([1,2] as $a) {   $this->comp[1] = $this->comp[0]->addSlot("a2", Parsed::template("block/a?slot=a2&id=38", ['slot' => 'a2', '_index' => '99'])->setSlots($this->slots));  }   $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("block/b", []);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("block/b?slot=b1&id=44", ['slot' => 'b1', '_index' => '2.5'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("b12", Parsed::template("block/b?slot=b12&id=45", ['slot' => 'b12', '_index' => '2.5'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("b122", Parsed::template("block/b?slot=b122&id=46", ['slot' => 'b122', '_index' => '99'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("***block", [])->withName("b1")->setSlots($this->slots));  $this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=47", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=48", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

<?php foreach ([1,2] as $k) {   $this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=50", ['_index' => 1])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData);  }  ?>

-----

<?php foreach ([1,2] as $k) {   $this->comp[0] = Parsed::template("***block", ['k' => $k])->withName("b1")->setSlots($this->slots);  $this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("comp/simple", ['_index' => '1']));  $this->comp[0]->render($this->scopeData);  }  ?>

-----

 <?php };