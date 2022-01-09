<?php isset($value) ?: $value = array_keys($tabs)[0]; ?> 
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" p-foreach="$tabs as $i => $tab">
    <?php if (isset($this->slots['tab.'.$i])) {
        $this->slots['tab.'.$i]->render($data);
    } else { ?>
    <a class="nav-link" :class="$value === $i ? 'active' : ''" data-toggle="tab" :href="'#'.$i" role="tab" :aria-controls="$i" :aria-selected="$i === $value ? 'true' : 'false'">{{ $tab }}</a>
    <?php } ?>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
    <slot></slot>
</div>