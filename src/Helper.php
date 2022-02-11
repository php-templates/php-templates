<?php

namespace PhpTemplates;

use PhpTemplates\Config;

class Helper {
    
    private static $uid = 0;

    public static function uniqid()
    {
        self::$uid += 1;
        return self::$uid;
    }

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
                    $result->statements[] = [$k, $val];
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
    
        // we can t calculate if prev sibling has conditions attached because it has been already processed and would always trigger the error. Instead, we do the reverse -> check if next node is ok
        if (array_intersect(['elseif', 'else'], array_keys($result->statements)) && empty($node->previousSibling)) {
            throw new InvalidNodeException('Unexpected elseif|else on node', $node);
        }
        
        return $result;
    }
    
    public static function isComponent($node)
    {
        if (!@$node->nodeName) {
            return null;
        }
        if ($node->nodeName === 'template') {
            return $node->getAttribute('is');
        }

        return Config::getComponentByAlias($node->nodeName);
    }
    
    public static function arrayToEval(array $arr, $simple = false)
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
            $stream[] = "'$key' => $value";
        }
        
        return '['. implode(', ', $stream) .']';
    }
    
    public static function isEmptyNode($node) {
        return $node->nodeName === '#text' && !trim($node->nodeValue);
    }
    
    public static function mergeAttrs(...$attrs)// spread
    {
        foreach ($attrs as $attr) {
            if (!is_string($attr)) {
                return $attrs;
            }
        }
        return implode(' ', $attrs);
    }
}