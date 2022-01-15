<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['slot_default?id=61e3193b8f490'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['title',])));
      if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php }  
};
Parsed::$templates['components/card'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
     ?><div class="card">
    <div class="card-body">
        <?php 
    if (!empty($this->slots["title"])) {
    foreach ($this->slots['title'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e3193b8f490', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </div>
</div><?php 
};
Parsed::$templates['components/table'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><table class="table table-striped">
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
</table><?php 
};
Parsed::$templates['components/card_slot_default?id=61e3193b8feec'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('components/table', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['stats'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
      $this->comp[0] = Parsed::template('components/card', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('components/card_slot_default?id=61e3193b8feec', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  
};