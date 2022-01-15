<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['components/tabs'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','tabs','i','tab','this','data','slots','slot',])));
      isset($value) ?: $value = array_keys($tabs)[0]; ?><ul class="nav nav-tabs" id="myTab" role="tablist"><?php foreach ($tabs as $i => $tab) { ?><li class="nav-item">
    <?php if (isset($this->slots['tab.'.$i])) {
        $this->slots['tab.'.$i]->render($data);
    } else { ?>
    <a class="nav-link <?php echo $value === $i ? 'active' : '' ;?>" data-toggle="tab" role="tab" href="<?php echo '#'.$i ;?>" aria-controls="<?php echo $i ;?>" aria-selected="<?php echo $i === $value ? 'true' : 'false' ;?>"><?php echo htmlspecialchars($tab); ?></a>
    <?php } ?></li><?php } ?>
</ul><div class="tab-content" id="myTabContent">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></div><?php 
};