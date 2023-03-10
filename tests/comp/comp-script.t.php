<div>
    comp script
</div>

<script>execution</script>

<?php 
return new class
{
    public function parsing($dom, $registry) {//d($registry);
        $script2 = $dom->querySelector('script')->detach();
        $registry->data['head'][] = '<script src="cdn">cdn script</script>';
        $registry->data['footer'][] = $script2;
    }
}
?>