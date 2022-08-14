<?php echo file_get_contents('https://www.bbc.com/news'); ?>
<?php return function($node) {
    //$t1 = $node->querySelector('meta[name="x-country"]')[0];
    $t2 = $node->querySelector('.nw-c-full-story .gs-u-mt@xs')[0];
    dom($t2);
    //$node->empty();
} ?>

-----
