<?php use DomDocument\PhpTemplates\Component; ?>
<?php function components_formgroup_40b1d_84ae1($data, $slots) {
extract($data);?>
        <div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php
            if (!empty($slots["label"])) {
        foreach ($slots["label"] as $slot) {
        $slot->render(['name' => 'label']);}
        }
        else  {
         ?>
                    <label class="form-label">{{ $label }}</label>
                <?php }
         ?>
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render([]);}
        }
        else  {
         ?>
                    <input type="text" class="form-control">
                <?php }
         ?>
    <?php if (!empty($error)) { ?><span class="error">{{ $error }}</span><?php } ?>
</div>
        <?php } ?>
<?php function slot_label_617f972ecfb99($data, $slots) {
extract($data);?>
        <div>Form label</div>
        <?php } ?>
<?php function components_helper_7bc48($data, $slots) {
extract($data);?>
        <span class="help-circle">
    <?php
            if (!empty($slots["default"])) {
        foreach ($slots["default"] as $slot) {
        $slot->render([]);}
        }
         ?>
</span>
        <?php } ?>
<?php function slot_default_617f972ed051e($data, $slots) {
extract($data);?>
        This is a simple helper
        <?php } ?>
<?php function slot_label_617f972ed05b4($data, $slots) {
extract($data);?>
        <div>
        {{ $label }}
        <?php
            
        $comp1 = new Component('components_helper_7bc48', []);
                $comp2 = $comp1->addSlot('default', new Component('slot_default_617f972ed051e', []));
        $comp1->render(); ?>
    </div>
        <?php } ?>
<!DOCTYPE html>
<html>
<body><?php
            
        $comp0 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text']);
                $comp1 = $comp0->addSlot('label', new Component('slot_label_617f972ecfb99', []));
        $comp0->render(); ?>

<?php
            
        $comp0 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text']);
        $comp0->render(); ?>

<?php
            
        $comp0 = new Component('components_formgroup_40b1d_84ae1', ['type' => 'text']);
                $comp1 = $comp0->addSlot('label', new Component('slot_label_617f972ed05b4', []));
        $comp0->render(); ?></body></html>
