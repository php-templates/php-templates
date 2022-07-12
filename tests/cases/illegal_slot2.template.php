<div><slot></slot></div>
<?php

 return function($node) {
  // $append = \PhpTemplates\Dom\DomNode::fromString('<slot tobeappended></slot>');
  $node->querySelector('slot')->appendChild('<slot tobeappended><slot></slot></slot>');
}
?>
=====
Invalid slot location (slot in slot not allowed) in illegal_slot2.template.php at line 6