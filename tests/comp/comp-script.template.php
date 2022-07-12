<div>
    comp script
</div>

<script>execution</script>

<?php 
return function($node)
{
    $head = $node->root->querySelector('head');
    $body = $node->root->querySelector('body');
    $script2 = $node->querySelector('script');
    $head->appendChild('<script src="cdn">cdn script</script>');
    $body->appendChild($script2->detach());
}
?>