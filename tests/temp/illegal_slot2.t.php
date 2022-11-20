<div><slot></slot></div>
<?php

 return function($process) {
  // $append = \PhpTemplates\Dom\DomNode::fromString('<slot tobeappended></slot>');
  $this->querySelector('slot')->appendChild('<slot tobeappended><slot></slot></slot>');
}
?>

-----
