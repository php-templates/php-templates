<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['nav-items?slot=1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <li>
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li> <?php 
};
Parsed::$templates['nav-items?slot=2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <li>
            <a class="nav-link" href="#">Link</a>
          </li> <?php 
};
Parsed::$templates['nav-items?slot=3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <li>
            <a class="nav-link disabled" href="#">Disabled</a>
          </li> <?php 
};
Parsed::$templates['nav-right?slot=4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <form>
          <input class="form-control mr-sm-2" type="search" placeholder="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> <?php 
};
Parsed::$templates['components/navbar'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("nav-items")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("nav-items", Parsed::template("nav-items?slot=1", ['class' => 'nav-item active', '_index' => '1'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("nav-items", Parsed::template("nav-items?slot=2", ['class' => 'nav-item', '_index' => '2'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("nav-items", Parsed::template("nav-items?slot=3", ['class' => 'nav-item', '_index' => '3'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
    </ul>
    
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("nav-right")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("nav-right", Parsed::template("nav-right?slot=4", ['class' => 'form-inline my-2 my-lg-0', '_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>
  </div>
</nav>

 <?php 
};
Parsed::$templates['layouts/app'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    
    <body>
        
<?php ;
$this->comp[0] = Parsed::template("components/navbar", []);
$this->comp[0]->render($this->data);
 ?>
        
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?>
    </body>
</html> <?php 
};
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
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['class','this','_slot','label','type','value','placeholder','options','name','values','val','_attrs','k','v','error',]));
     ?> <div class="<?php echo Helper::mergeAttrs('form-group',!empty($class) ? $class : ''); ?>">
    
<?php ;
foreach ($this->slots("label") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("label"))) {
 ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label>
<?php ;
}
 ?>
    
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("default"))) {
if ($type === 'text') { 
 ?><input type="text" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php ;
} 
elseif ($type === 'number') { 
 ?><input type="number" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php ;
} 
elseif ($type === 'email') { 
 ?><input type="email" class="form-control" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder ?? $label; ?>">
<?php ;
} 
elseif ($type === 'checkbox') { 
foreach ($options as $name => $label) { 
 ?><label>
            <input type="checkbox" <?php echo (in_array($name, $values) ? 'checked' : '') ?> value="1">
            <?php echo htmlspecialchars($label); ?>
        </label>
<?php ;
} 
} 
elseif ($type === 'radio') { 
foreach ($options as $val => $label) { 
 ?><label>
            <input type="radio" <?php echo ($val == $value ? 'checked' : '') ?> name="<?php echo $name; ?>" value="<?php echo $val; ?>">
            <?php echo htmlspecialchars($label); ?>
        </label>
<?php ;
} 
} 
elseif ($type === 'select') { 
 ?><select class="form-control">
            
<?php ;
foreach ($options as $val => $label) { 
 ?><option <?php echo ($val == $value ? 'checked' : '') ?> value="<?php echo $val; ?>"><?php echo htmlspecialchars($label); ?></option>
<?php ;
} 
 ?>
        </select>
<?php ;
} 
elseif ($type === 'textarea') { 
 ?><textarea class="form-control" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?> placeholder="<?php echo $placeholder ?? $label; ?>"><?php echo htmlspecialchars($value); ?></textarea>
<?php ;
} 
}
 ?>
    
<?php ;
if (!empty($error)) { 
 ?><span class="error"><?php echo htmlspecialchars($error); ?></span>
<?php ;
} 
 ?>
</div>

 <?php 
};
Parsed::$templates['form-fields?slot=5'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','entry_firstname','firstname','entry_lastname','lastname',]));
     ?> <div>
            
<?php ;
$this->comp[0] = Parsed::template("components/form-group", ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);
$this->comp[0]->render($this->data);
 ?>
            
<?php ;
$this->comp[0] = Parsed::template("components/form-group", ['type' => 'text', 'class' => 'col-6', 'name' => 'lastname', 'label' => $entry_lastname, 'value' => $lastname]);
$this->comp[0]->render($this->data);
 ?>
        </div> <?php 
};
Parsed::$templates['components/helper'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <i class="fas fa-question-circle"></i>


<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
?>

 <?php 
};
Parsed::$templates['components/helper?slot=default&id=7'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> Helper <?php 
};
Parsed::$templates['components/form-group?slot=label&id=6'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <label>
<?php ;
$this->comp[0] = Parsed::template("components/helper", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("components/helper?slot=default&id=7", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?> Label with helper</label> <?php 
};
Parsed::$templates['user-profile-form'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','entry_email','email','entry_male','entry_female','entry_gender','gender',]));
     ?> 
<?php ;
$this->comp[0] = Parsed::template("components/card", ['title' => 'My form']);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("***block", [])->withName("form-fields")->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("form-fields", Parsed::template("form-fields?slot=5", ['class' => 'row', '_index' => '1'])->setSlots($this->slots));

$this->comp[2] = $this->comp[1]->addSlot("form-fields", Parsed::template("components/form-group", ['type' => 'email', 'name' => 'email', '_index' => '2', 'label' => $entry_email, 'value' => $email]));

$this->comp[2] = $this->comp[1]->addSlot("form-fields", Parsed::template("components/form-group", ['type' => 'select', 'name' => 'gender', '_index' => '3', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'label' => $entry_gender, 'value' => $gender]));

$this->comp[2] = $this->comp[1]->addSlot("form-fields", Parsed::template("components/form-group", ['type' => 'checkbox', 'name' => 'options', 'label' => 'Options', '_index' => '4', 'options' => ['o1' => 'A', 'o2' => 'B'], 'values' => ['o1']]));

$this->comp[2] = $this->comp[1]->addSlot("form-fields", Parsed::template("components/form-group", ['type' => 'radio', 'name' => 'radio', 'label' => 'Radio', 'value' => '2', '_index' => '5', 'options' => ['1' => 'A', '2' => 'B']]));

$this->comp[2] = $this->comp[1]->addSlot("form-fields", Parsed::template("components/form-group", ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text', '_index' => '6']));

$this->comp[3] = $this->comp[2]->addSlot("label", Parsed::template("components/form-group?slot=label&id=6", ['slot' => 'label', '_index' => '0'])->setSlots($this->slots));


$this->comp[0]->render($this->data);
?>

 <?php 
};
new DomEvent('rendering', 'user-profile-form', function($template, $data) {
            $comp = Parsed::template('layouts/app', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });