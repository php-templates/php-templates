<?php

namespace PhpTemplates\Parsed;

/**
 * Echo escaped string
 */
function e($string)
{
    if ($string && !is_string($string)) {
        $string = json_encode($string);
    }
    echo htmlentities((string)$string);
}

function resolve_class(array $class) 
{
    $result = [];
    foreach ($class as $k => $val) {
        if (is_numeric($k)) {
            // class="[foo ? bar : '']"
            if ($val) {
                $result[] = $val;
            }
        }
        elseif ($val) {
            // class="[foo => true]"
            $result[] = $k;
        }
    }
    
    return implode(' ', $result);
}

function e_bind($array, array $except = [])
{
    $array = array_diff_key((array)$array, array_flip($except));
    $result = [];
    foreach ($array as $k => $val) {
        if (is_bool($val)) {
            if ($val) {
                $result[] = $k;
            }
            continue;
        }
        
        $val = !is_string($val) ? json_encode($val) : $val;
        if (strlen(trim($val))) {
            $result[] = $k . '="' . htmlentities($val) . '"';
        }
        elseif ($k) {
            $result[] = $k;
        }
    }
    
    echo implode(' ', $result);
}

function arr_except(array $arr, $except) {
    foreach ((array)$except as $except) {
        unset($arr[$except]);
    }
    
    return $arr;
}