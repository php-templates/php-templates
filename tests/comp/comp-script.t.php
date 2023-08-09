<div>
    comp script
</div>

<script>execution</script>

<?php 
return new class
{
    public function parsing($dom) {
        $script = $dom->querySelector('script')->detach();
        
        \PhpTemplates\Event::once('parsed', 'temp/comp-script', function($dom) use($script) {
            $dom->querySelector('head')->appendChild($script);
        });
    }
}
?>