<?php

namespace PhpTemplates;

function view(string $view, array $data = [])
{
   
    ob_start();
    Template::load($view, $data);
    $output = ob_get_contents();
    ob_end_clean();
 
    return $output;
}