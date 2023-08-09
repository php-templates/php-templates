<?php

use PhpTemplates\Event as Event;

return new class
{
    public function parsing($n, $r) {
        Event::on('parsing', 'the/events', function() {
        echo 1;//1
        }, 5);
        Event::on('parsing', 'the/*/gonna', function() {
        echo 2;//2
        }, 4);
        Event::on('parsing', 'the/*/gonna*', function() {
        echo 3;//3
        }, 3);
        Event::on('parsing', 'the/*/gonna/*executed', function() {
        echo 4;//4
        }, 2);
        Event::on('parsing', 'the/*/gonna/*the/given/sort/order', function() {
        echo 5;//5
        }, 1);
        
        Event::once('once', 'the-once', function() {
        echo 'once';//5
        }, 999);
        
        echo '|';
        Event::trigger('parsing', 'the/events', null);
        echo '|';
        Event::trigger('parsing', 'the/events/gonna', null);
        echo '|';
        Event::trigger('parsing', 'the/events/gonnabe', null);
        echo '|';
        Event::trigger('parsing', 'the/events/gonna/be', null); // don t match
        echo '|';
        Event::trigger('parsing', 'the/events/gonna/beexecuted', null);
        echo '|';
        Event::trigger('parsing', 'the/events/gonna/inthe/given/sort/order', null);
        echo '|';
        Event::trigger('once', 'the-once', null);
        Event::trigger('once', 'the-once', null);
        Event::trigger('once', 'the-once', null);
    }
}

?>

=====

|1 |23 |3 | |4 |5 |once