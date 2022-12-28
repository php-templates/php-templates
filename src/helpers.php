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

/**
 * Check dependencies foreach file => filemtime and returns false in case of modification
 *
 * @param array $files
 * @return void
 */
function check_dependencies(array $files)
{
    foreach ($files as $file => $m) {
        if ($m < filemtime($file)) {
            return false;
        }
    }
    return true;
}

function parse_path(string $rfilepath, Config $config): array
{
    $cfgkey = '';
    if (strpos($rfilepath, ':')) {
        list($cfgkey, $rfilepath) = explode(':', $rfilepath);
    }
    
    if (!$cfgkey) {
        return [$rfilepath, $config->getRoot()];
    }
    
    if ($cfgkey == '@') {
        return [$rfilepath, $config];
    }
  
    $config = $config->getRoot()->find($cfgkey);
        
    return [$rfilepath, $config];
}

function arr_except(array $arr, $except) {
    foreach ((array)$except as $except) {
        unset($arr[$except]);
    }
    
    return $arr;
}