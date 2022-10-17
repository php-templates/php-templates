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

/**
 * Gain array of arrays of key => value attrs, or flat arrays and returns one dimmension array of k->val
 *
 * @param array ...$arrays
 * @return void
 */
function attr_merge(...$arrays) {
    $result = [];
    foreach ($arrays as $arr) {
        foreach ($arr as $k => $val) {
            if (!is_string($val)) {
                $val = json_encode($val);
            }
            $result[$k][] = $val;
        }
    }

    foreach ($result as $k => $val) {
        $result[$k] = implode(' ', array_unique($val));
    }

    return $result;
}

/**
 * accepts an array with attributes from a group, returns concated strings of it evaluated
 * supported syntaxes: attr_filter(['foo', '', 'foo' => true])
 * returns string concat
 *
 * @param array $attrs
 * @return void
 */
function attr_filter(array $attrs)
{
    $arr = [];
    foreach ($attrs as $attr) {
        if (is_array($attr)) {
            foreach ($attr as $k => $val) {
                if (is_string($k)) {
                    // case :class="[foo => true]"
                    if ($val) {
                        $arr[] = $k;
                    }
                }
                elseif (!is_string($val)) {
                    $arr[] = json_encode($val);
                }
                elseif ($val !== '') { // case class="[true ? bar : '']"
                    $arr[] = $val;
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

    return implode(' ', array_unique($arr));
}

/**
 * gain an array of k => val attributes and echo them as valid html dom node attr string
 *
 * @param array ...$attrs
 * @return void
 */
function bind(...$attrs)
{
    $result = [];
    foreach ($attrs as $attr) {
        foreach ($attr as $k => $val) {
            if (!is_string($val)) {
                $val = json_encode($val);
            }

            if (is_numeric($k)) {
                if ($val) {
                    $result[] = $val;
                }
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
        return true;
    }
}