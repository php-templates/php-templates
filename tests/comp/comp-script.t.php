<div>
    comp script
</div>

<script>execution</script>

<?php 
return function($process)
{
    $script2 = $this->querySelector('script')->detach();
    $process->on('parsed', 'temp/comp-script', function($dom) use ($script2) {
        $dom->querySelector('head')->appendChild('<script src="cdn">cdn script</script>');
        $dom->querySelector('body')->appendChild($script2);
    });
}
?>