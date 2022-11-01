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
                elseif (is_bool($val) && $val) {
                    // [[class => xyz], ...]          
                    $result[] = $attr;
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
        if ($attr && !$val) {
            $echo[] = $attr;
        }
        elseif ($attr == 'class' && is_array($val)) {
            $echo[] = $attr . '="' . implode(' ', $val) . '"';
        }
        elseif (is_array($val)) {
            $echo[] = $attr . '="' . end($val) . '"'; // todo: attrs cumulative only class
        }
        else {
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