<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['components/tabs'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['value','tabs','i','tab','this','data','_slot',]));
     ?> <?php isset($value) ?: $value = array_keys($tabs)[0]; ?>


<ul class="nav nav-tabs" id="myTab" role="tablist">
  
<?php ;
foreach ($tabs as $i => $tab) { 
 ?><li class="nav-item">
    <?php if (isset($this->slots['tab.'.$i])) {
        $this->slots['tab.'.$i]->render($data);
    } else { ?>
    <a data-toggle="tab" role="tab" class="<?php echo Helper::mergeAttrs('nav-link',$value === $i ? 'active' : ''); ?>" href="<?php echo '#'.$i; ?>" aria-controls="<?php echo $i; ?>" aria-selected="<?php echo $i === $value ? 'true' : 'false'; ?>"><?php echo htmlspecialchars($tab); ?></a>
    <?php } ?>
  </li>
<?php ;
} 
 ?>
</ul>


<div class="tab-content" id="myTabContent">
    
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?>
</div>

 <?php 
};