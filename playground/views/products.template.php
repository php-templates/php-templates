<div class="row">
    <template p-foreach="$products as $prod" :product="$prod" is="components/product_item" class="col-sm-3"></template>
</div>