<?php echo '<div class="'.(true ? 'some-class' : '').'">'; ?>
    <p p-foreach="[1,2] as $i"></p>
<?php echo '</div>'; ?>
=====
<div class="some-class">
    <p></p>
    <p></p>
</div>

