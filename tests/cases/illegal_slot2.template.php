<div><slot></slot></div>
<?php

 return function($node) {
  // $append = \PhpTemplates\Dom\DomNode::fromString('<slot tobeappended></slot>');
  $node->querySelector('slot')->appendChild('<slot tobeappended><slot></slot></slot>');
}
?>
=====
Invalid slot location (slot in slot not allowed) in F:\dev\exegeza\vendor\florin-botea\php-templates\tests\temp\illegal_slot2.template.php at line 6