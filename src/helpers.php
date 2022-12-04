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
 * @deprecated
 */
function e_attrs(...$data): void
{
    $result = [];
    
    static $convertValue = null;
    if (is_null($convertValue)) {
        $convertValue = function($key, $val) {
            if (is_array($val)) {
                // [[class => [[foo => bar], ...]], ...]         
                return json_encode($val);
            }
            elseif (is_bool($val) && $val) {
                // [[class => [foo => x > y]], ...]
                return $key;
            }
            elseif (is_numeric($key)) {
                // [[class => [foo, bar, ...]], ...]
                return $val;
            }
            elseif ($val) {
                return $key;
            }
        };
    }
    
    foreach ($data as $attr) {
        if (is_array($attr)) {
            // [[class => ...], ...$binds]
            foreach ($attr as $attr => $val) {
                if (is_array($val)) {
                    // [[class => [...]], ...]
                    foreach ($val as $key => $val) {
                        if (!is_null($val = $convertValue($key, $val))) {
                            $result[$attr][] = $val;
                        }
                    }
                }
                elseif (is_bool($val)) {
                    // [[class => xyz], ...] 
                    if ($val) {
                        $result[] = $attr;
                    }
                }
                else {
                    // [[class => xyz], ...]          
                    $result[$attr][] = $val;
                }
            }
        }
        elseif (is_string($attr)) {
            // [? required : '', ...] 
            $result[] = $attr;
        }
    }
    
    $echo = [];
    foreach ($result as $attr => $val) {
        if ($attr && (!$val || $val === true)) {
            $echo[] = $attr;
        }
        elseif ($attr == 'class' && is_array($val)) {
            $echo[] = $attr . '="' . implode(' ', $val) . '"';
        }
        elseif (is_array($val)) {
            $echo[] = $attr . '="' . end($val) . '"'; // todo: attrs cumulative only class
        }
        elseif($val) {
            $echo[] = $val;
        }
    }
    
    echo implode(' ', $echo);
}

function r_attrs(...$data): array
{
    //print_r($data);
    $result = [];
    
    foreach ($data as $attr) {
        if (!is_array($attr)) {
            // unreachable
            continue;
        }
        
        foreach ($attr as $attr => $val) {
            if ($attr == 'p-raw') {
                continue;
            }
            elseif ($attr == 'p-bind') {
                $result = array_merge($result, $val);
            }
            else {
                $result[$attr] = $val;
            }
        }
    }
    //print_r($result);
    return $result;
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

function e_bind(array $array, array $except = [])
{
    $array = array_diff_key($array, array_flip($except));
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
            $result[] = $k . '="' . $val . '"';
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