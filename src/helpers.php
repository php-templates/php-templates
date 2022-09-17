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
function attr(...$data): string
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
    return implode(' ', $class);
}

function attr_merge(...$arrays) {
    $result = array_shift($arrays);
   
    foreach ($arrays as $arr) {
        foreach ($arr as $k => $val) {
            if (isset($result[$k])) {
                if (!is_string($result[$k]) || !is_string($val)) {
                    $result[$k] = array_merge($result[$k], $val);
                }
                else {
                    $result[$k] .= ' ' . $val;
                }
            } else {
                $result[$k] = $val;
            }
        }
    }
    
    return $result;
}

// accepts an array with attributes from a group, returns concated strings of it evaluated
// supported syntaxes: attr_filter(['foo', '', 'foo' => true])
// returns string concat
function attr_filter(array $attrs)
{
    $arr = [];
    foreach ($attrs as $attr) {
        if (is_array($attr)) {
            foreach ($attr as $k => $val) {
                if (is_string($k) && $val) {
                    // case :class="[foo => true]"
                    $arr[] = $k;
                }
                elseif (!is_string($val)) {
                    $attr[] = json_encode($val);
                }
                elseif ($val !== '') { // case class="[true ? bar : '']"
                    $attr[] = $val;
                }
            }
        }
        elseif (!is_string($attr)) {
            $arr[] = json_encode($attr);
        }
        elseif ($attr !== '') {
            $arr[] = $attr;
        }
    }
    
    return implode(' ', $arr);
}

function bind(...$attrs) 
{
    $result = [];
    foreach ($attrs as $attr) {
        foreach ($attr as $k => $val) {
            if (!is_string($val)) {
                $val = json_encode($val);
            }
            
            if (is_numeric($k)) {
                $result[] = $val;
            }
            elseif (isset($result[$k])) {
                $result[$k] .= ' ' . $val;
            }            
            else {
                $result[$k] = $val;
            }
        }
    }
    
    $output = [];
    foreach ($result as $name => $value) {
        if (is_numeric($name)) {
            $output[] = $value;
        } else {
            $output[] = $name . '="' . $value .'"';
        }
    }
    echo implode(' ', $output);
}

function check_dependencies(array $files)
{
    foreach ($files as $file => $m) {
        if ($m < filemtime($file)) {
            return false;
        }
        return true;
    }
}