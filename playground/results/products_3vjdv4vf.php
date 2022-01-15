<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['components/product_item'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['product',])));
     ?><div class="card bg-light <?php echo isset($class) ? $class : '' ;?>">
  <img class="card-img-top" src="/playground/views/images.jpeg" alt="Card image cap"><div class="card-body">
    <p class="card-text"><?php echo htmlspecialchars($product['name']); ?></p>
  </div>
</div><?php 
};
Parsed::$templates['products'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['products','prod','comp0','data',])));
     ?><div class="row">
    <?php 
    foreach ($products as $prod) {$comp0 = Parsed::template('components/product_item', ['product' => $prod, 'class' => 'col-sm-3']);

    $comp0->render($data);
    } ?></div><?php 
};