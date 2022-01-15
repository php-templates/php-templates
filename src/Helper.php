<?php

namespace PhpTemplates;

use PhpTemplates\Config;

class Helper {
    
    public static function nodeStdClass($node, $context = '')
    {
        $specials = ['is', 'slot'];
        if (in_array($node->nodeName, ['slot', 'block'])) {
            array_push($specials, 'name', 'bind');
        }
        if ($context === 'slot') {
            array_push($specials, 'slot', 'bind');
        }
        $result = new \stdClass;
        $result->statements = [];
        $result->attributes = [];
        $result->bind = null;
        foreach ($specials as $spec) {
            $result->$spec = null;
        }
        $result->slot = 'default';
        
        $attrs = $node->attributes ? $node->attributes : [];
        foreach ($attrs as $attr) {
            $k = $attr->nodeName;
            $val = $attr->nodeValue;
            if (in_array($k, $specials)) {
                $result->$k = $val;
            }
            elseif (strpos($k, 'p-') === 0) 
            {
                $k = substr($k, 2);
                if (in_array($k, Config::allowedControlStructures)) {
                    $result->statements[$k] = $val;
                }
            }
            elseif (in_array(trim($k, ':'), Config::attrCumulative) && !empty($result->attributes[$k])) {
                $result->attributes[$k] .= ' '.$val;
            } else {
                $result->attributes[$k] = $val;
            }
        }
        
        if ($node->nodeName === 'slot') {
            if (!$result->name) {
                $result->name = 'default';
            }
        }
        
        if ($node->nodeName === 'block' && empty($result->name)) {
            throw new InvalidNodeException("Block node should have a 'name=\"value\"' attribute", $node);
        }
        
        return $result;
    }
    
    public static function isComponent($node)
    {
        if (!@$node->nodeName) {
            return null;
        }
        if ($node->nodeName === 'component') {
            return $node->getAttribute('is');
        }

        return Config::getComponentByAlias($node->nodeName);
    }
    
    public static function arrayToEval(array $arr, $simple = false, $unescape = ':')
    {// todo nu va mergw cu array de genul [$foo, $bar]
        if (!$arr) {
            return '[]';
        }
        $isAssoc = array_keys($arr) !== range(0, count($arr) - 1);
        if (!$isAssoc || $simple) {
            $arr = var_export($arr, true);
            $arr = str_replace(['array (', ')', '\n', '\r', PHP_EOL], ['[', ']', '', '', ''], $arr);
            $arr = preg_replace('/\d+[ ]*\\=>[ ]*/', '', $arr);
            //var_dump(utf8_encode ($arr));dd();
            return trim($arr, ',');
        }
        
        $stream = [];
        foreach ($arr as $key => $value) {
            if (strpos($key, $unescape) === 0) {
                $key = str_replace($unescape, '', $key);
            } else {
                $value = "'$value'";
            }
            $stream[] = "'$key' => $value";
        }
        
        return '['. implode(', ', $stream) .']';
    }
    
    public static function isEmptyNode($node) {
        return $node->nodeName === '#text' && !trim($node->nodeValue);
    }
}