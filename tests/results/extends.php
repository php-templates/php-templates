<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['extends/parent'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <parent>
<?php foreach ($this->slots("d1") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("d1"))) { ?><div>123</div>
<?php }  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></parent>

 <?php 
};
Parsed::$templates['extends/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <a>
    <foo></foo></a>

 <?php 
};
Parsed::$templates['extends/parent2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['bind_me',]));
     ?> <parent2>
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></parent2>

 <?php 
};
Parsed::$templates['extends/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b></b>

 <?php 
};
Parsed::$templates['extends/parent4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['bind_me',]));
     ?> <parent4>
    parent4
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></parent4>

 <?php 
};
Parsed::$templates['extends/parent3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['bind_me',]));
     ?> <parent3>
    parent3
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></parent3>

 <?php 
};
Parsed::$templates['extends/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b></b>

 <?php 
};
Parsed::$templates['./temp/extends'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("extends/a", []);  $this->comp[0]->render($this->data); ?>

-----



<?php $this->data['bind_me'] = 'bound';  $this->comp[0] = Parsed::template("extends/b", []);  $this->comp[0]->render($this->data); ?>

-----

<?php $this->comp[0] = Parsed::template("extends/c", []);  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};
new DomEvent('rendering', 'extends/a', function($template, $data) {
            $comp = Parsed::template('extends/parent', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
new DomEvent('rendering', 'extends/b', function($template, $data) {
            $comp = Parsed::template('extends/parent2', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
new DomEvent('rendering', 'extends/parent3', function($template, $data) {
            $comp = Parsed::template('extends/parent4', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
new DomEvent('rendering', 'extends/c', function($template, $data) {
            $comp = Parsed::template('extends/parent3', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });