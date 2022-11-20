<?php

return function($process) 
{
$e = $process->events;
$e->on('parsing', 'the/events', function() {
    echo 1;//1
}, 5);
$e->on('parsing', 'the/*/gonna', function() {
    echo 2;//2
}, 4);
$e->on('parsing', 'the/*/gonna*', function() {
    echo 3;//3
}, 3);
$e->on('parsing', 'the/*/gonna/*executed', function() {
    echo 4;//4
}, 2);
$e->on('parsing', 'the/*/gonna/*the/given/sort/order', function() {
    echo 5;//5
}, 1);

echo '|';
$e->event('parsing', 'the/events', null);
echo '|';
$e->event('parsing', 'the/events/gonna', null);
echo '|';
$e->event('parsing', 'the/events/gonnabe', null);
echo '|';
$e->event('parsing', 'the/events/gonna/be', null); // don t match
echo '|';
$e->event('parsing', 'the/events/gonna/beexecuted', null);
echo '|';
$e->event('parsing', 'the/events/gonna/inthe/given/sort/order', null);


}

?>

=====

|1 |23 |3 | |4 |5