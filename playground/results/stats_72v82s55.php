<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['components/card'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot','title',]));
     ?> <div class="card">
    <div class="card-body">
        
<?php ;
foreach ($this->slots("title") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("title"))) {
if (isset($title)) { 
 ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
<?php ;
} 
}
 ?>
        
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?>
    </div>
</div>

 <?php 
};
Parsed::$templates['components/table'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

 <?php 
};
Parsed::$templates['stats'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <?php ;
$this->comp[0] = Parsed::template("components/card", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("components/table", []));

$this->comp[0]->render($this->data);
?>

 <?php 
};