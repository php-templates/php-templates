<html>
    <head>
        
    </head>
    <body>
        <tpl is="comp/comp-script"></tpl>
    </body>
</html>
<?php 

use PhpTemplates\Dom\Parser;
use PhpTemplates\Dom\Parser as Testare;

return new class {
    public function parsed($node, $registry) {//dd($registry->data);
        $head = $node->querySelector('head');
        $body = $node->querySelector('body');
        foreach ($registry->data['head'] ?? [] as $script) {
            $head->appendChild($script);
        }
        foreach ($registry->data['footer'] ?? [] as $script) {
            $body->appendChild($script);
        }
        // dd(''.$node);
    }
    
    public function data($data) {
        $data['parser'] = new Parser();
        return $data;
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