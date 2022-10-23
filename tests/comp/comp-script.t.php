<div>
    comp script
</div>

<script>execution</script>

<?php 
return function($node, $eh)
{
        $script2 = $node->querySelector('script');
        $script2->detach();
    $eh->on('parsed', 'temp/comp-script', function($root) use ($script2) {
        $head = $root->querySelector('head');
        $body = $root->querySelector('body');
        $head->appendChild('<script src="cdn">cdn script</script>');
        //$node->dd();
        $body->appendChild($script2);        
    });
}
?>