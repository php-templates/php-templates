<div>
    this will register a document script only once
</div>

<?php 
return [
    'booted' => function(&$data) {
        $data["scripts"]['myscript'] = 'alert(1)';
    }
];
?>