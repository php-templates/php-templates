<html>
    <head>
        
    </head>
    <body>
        <tpl is="comp/comp-script"></tpl>
    </body>
</html>
<?php 

return function($process) {
    $head = $this->querySelector('head');
    $body = $this->querySelector('body');
    foreach ($process->data->scripts['header'] ?? [] as $script) {
        $head->appendChild($script);
    }
    foreach ($process->data->scripts['footer'] ?? [] as $script) {
        $body->appendChild($script);
    }
}; ?>
=====
<html>
    <head>
        <script src="cdn">cdn script</script>
    </head>
    <body>
        <div>
            comp script
        </div>
        <script>execution</script>
    </body>
</html>