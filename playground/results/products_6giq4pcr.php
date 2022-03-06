<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['components/product_item'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['class','product',]));
     ?> <div class="<?php echo Helper::mergeAttrs('card bg-light',isset($class) ? $class : ''); ?>">
  <img class="card-img-top" src="/playground/views/images.jpeg" alt="Card image cap">
  <div class="card-body">
    <p class="card-text"><?php echo htmlspecialchars($product['name']); ?></p>
  </div>
</div>

 <?php 
};
Parsed::$templates['products'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['products','prod','this',]));
     ?> <div class="row">
    
<?php ;
foreach ($products as $prod) { 
$this->comp[0] = Parsed::template("components/product_item", ['class' => 'col-sm-3', 'product' => $prod]);
$this->comp[0]->render($this->data);
} 
 ?>
</div>

 <?php 
};