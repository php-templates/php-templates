<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['components/dropdown'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['text','this','_slot',]));
     ?> <div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php echo htmlspecialchars($text); ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?>
    </div>
</div>

 <?php 
};