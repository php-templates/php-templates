<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['extends/parent'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <parent>
<?php foreach ($this->slots("d1") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("d1"))) { ?><div>123</div>
<?php }  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></parent>

 <?php };
Parsed::$templates['extends/a'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <a>
    <foo></foo></a>

 <?php };
Parsed::$templates['extends/parent2'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <parent2>
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></parent2>

 <?php };
Parsed::$templates['extends/b'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b></b>

 <?php };
Parsed::$templates['extends/parent4'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <parent4>
    parent4
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></parent4>

 <?php };
Parsed::$templates['extends/parent3'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <parent3>
    parent3
    <?php echo htmlspecialchars($bind_me);  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></parent3>

 <?php };
Parsed::$templates['extends/c'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b></b>

 <?php };
Parsed::$templates['./temp/extends'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("extends/a", []);  $this->comp[0]->render($this->scopeData); ?>

-----



<?php $this->scopeData['bind_me'] = 'bound';  $this->comp[0] = Parsed::template("extends/b", []);  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("extends/c", []);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };
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