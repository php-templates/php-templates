<div class="row">
    <component p-foreach="$products as $prod" :product="$prod" is="components/product_item" class="col-sm-3"></component>
</div>