<?php

namespace PhpTemplates;

/**
 * Echo escaped string
 *
 * @param string $string
 * @return void
 */
function e($string) 
{
    echo htmlspecialchars((string)$string);
}

/**
 * Gain array or string as param and echo it as class string
 *
 * @param mixed $data
 * @return void
 */
function attr(...$data)
{
    $class = [];
    foreach ($data as $data) {
        if (is_array($data)) {
            $class[] = implode(' ', array_keys(array_filter($data)));
        } 
        elseif(is_string($data)) {
            $class[] = $data;
        }
    }
    echo implode(' ', $class);
}