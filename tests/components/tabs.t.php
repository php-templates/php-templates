<ul class="nav nav-tabs" role="tablist">
  <li p-foreach="$tabs as $id => $label" class="nav-item" role="presentation">
    <button class="nav-link" :class="$id == $value ? 'active' : ''" :id="$id.'-tab'" data-bs-toggle="tab" :data-bs-target="'#'.$id" type="button" role="tab" :aria-controls="$id" :aria-selected="$id == $value ? 'true' : 'false'">
      {{ $label }}
    </button>
  </li>
</ul>
<div class="tab-content p-2">
  @php 
    $ids = array_keys($tabs); 
  @endphp
  <tpl p-foreach="$this->slots('tab-pane') as $i => $slot">
    <div class="tab-pane fade" :class="$ids[$i] == $value ? 'show active' : ''" :id="$ids[$i]" role="tabpanel" :aria-labelledby="$ids[$i].'-tab'">
      @php $slot(); @endphp
    </div>
  </tpl>
</div>