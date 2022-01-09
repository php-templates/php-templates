<div class="card bg-light" :class="isset($class) ? $class : ''">
  <img class="card-img-top" src="/playground/views/images.jpeg" alt="Card image cap">
  <div class="card-body">
    <p class="card-text">{{ $product['name'] }}</p>
  </div>
</div