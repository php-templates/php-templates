<div>
    comp script
</div>

<script>execution</script>

<?php 
return function($process)
{
    $script2 = $this->querySelector('script')->detach();
    $process->data->scripts['footer'][] = $script2;
    $process->data->scripts['header'][] = '<script src="cdn">cdn script</script>';
}
?>