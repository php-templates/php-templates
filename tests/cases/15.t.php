<a p-foreach="[1,2] as $i => $tab" class="nav-link" :class="6 === $i ? 'active' : ''" data-toggle="tab" :href="'#'.$i" role="tab" :aria-controls="$i" :aria-selected="$i === 6 ? 'true' : 'false'">{{ $tab }}</a>
=====
<a class="nav-link" data-toggle="tab" href="#0" role="tab" aria-controls="0" aria-selected="false">1</a>
<a class="nav-link" data-toggle="tab" href="#1" role="tab" aria-controls="1" aria-selected="false">2</a>