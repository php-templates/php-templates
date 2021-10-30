<?php use DomDocument\PhpTemplates\Component; ?><?php function components_formgroup_40b1d($data, $slots) {
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
        <?php } ?><?php function slot_617dad54e8510($data, $slots) {
extract($data);?>
        <div slot="label">Form label</div>
        <?php } ?><!DOCTYPE html>
<html>

<body><?php
            
        $comp0 = new Component('components_formgroup_40b1d', ['type' => 'text']);
                $comp1 = $comp0->addSlot('label', new Component('slot_617dad54e8510', []));
        $comp0->render(); ?>

<?php
            
        $comp0 = new Component('components_formgroup_40b1d', ['type' => 'text']);
        $comp0->render(); ?>
<?php
            
        $comp0 = new Component('components_formgroup_40b1d', []);
        $comp0->render(); ?></body>
</html>