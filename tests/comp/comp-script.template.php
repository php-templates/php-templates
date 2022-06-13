<div>
    comp script
</div>

<script>execution</script>

<?php 
return function($node)
{
    $head = $node->root->querySelector('head')[0];
    $body = $node->root->querySelector('body')[0];
    $script2 = $node->querySelector('script')[0];
    $head->appendChild('<script src="cdn">cdn script</script>');
    $body->appendChild($script2->detach());
}
?>