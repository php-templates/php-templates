<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./temp/15'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['i','tab',]));
      foreach ([1,2] as $i => $tab) {  ?>
<a data-toggle="tab" role="tab" class="<?php echo Helper::mergeAttrs('nav-link',6 === $i ? 'active' : ''); ?>" href="<?php echo '#'.$i; ?>" aria-controls="<?php echo $i; ?>" aria-selected="<?php echo $i === 6 ? 'true' : 'false'; ?>"><?php echo htmlspecialchars($tab); ?></a>
<?php }  ?>

-----

 <?php 
};