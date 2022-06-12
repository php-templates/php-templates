<div>
    comp script
</div>

<?php 
return function($node)
{
    //dd($node->root->childNodes[0]->debug());
    $node->root->childNodes[0]->childNodes[1]->detach();
} 
?>