<div><slot></slot></div>
<?php

 return function($node) {
  // $append = \PhpTemplates\Dom\DomNode::fromString('<slot tobeappended></slot>');
  $node->querySelector('slot')->appendChild('<slot tobeappended><slot></slot></slot>');
}
?>

-----
