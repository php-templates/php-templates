<?php use DomDocument\PhpTemplates\Component; ?>
<?php function components_card_110b0($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'comp0',
  1 => 'comp2',
  2 => 'comp1',
  3 => 'slots',
  5 => 'slot',
  7 => 'data',
  8 => 'title',
)))); ?>
        <div class="card">
    <div class="card-body">
        <?php
            
            $comp0 = new Component('userprofileform_11181', []);
            $comp2 = $comp1->addSlot('components_card_110b0', []);if (!empty($slots["title"])) {
        foreach ($slots["title"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <?php if (isset($title)) { ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php } ?><html></html>
                <?php }
         ?>
        <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
         ?>
    </div>
</div>
        <?php } ?>
<?php function components_formgroup_40b1d_8b4ba($data, $slots) {
extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, array (
  0 => 'class',
  2 => 'slots',
  4 => 'slot',
  6 => 'data',
  7 => 'label',
  13 => 'placeholder',
  15 => '_attrs',
  16 => 'k',
  17 => 'v',
  20 => 'value',
  21 => 'error',
)))); ?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <label class="form-label"><?php echo htmlspecialchars($label); ?></label><html></html>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render($data);}
        }
        else  {
         ?>
                    <textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><html></html>
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div>
        <?php } ?>
