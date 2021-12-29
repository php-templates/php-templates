<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Facades\Config;

class Helper {
    public static function getTemplateName()
    {
        
    }
    
    public static function getNodeAttributes($node, $reset = 0) {
        $attrs = [];
        $special = array_merge(Config::allowedControlStructures, [
            'slot', 'is',
        ]);
        if ($node->nodeName === 'slot') {
            $special[] = 'name';
        }
        foreach ($node->attributes ?? [] as $attr) {
            $attrs[$attr->nodeName] = $attr->nodeValue;
            if ($reset === 1) {
                $node->removeAttribute($attr->nodeName);
            } 
            elseif ($reset === 2 && in_array($attr->nodeName, $special)) {
                $node->removeAttribute($attr->nodeName);
            }
        }
        return $attrs;
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
        
        foreach (self::getNodeAttributes($node) as $k => $val) {
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
        
        // validari
        // if ($node->nodeName === 'component') {
        //     if (empty($result->is)) {
        //         //dd($result);
        //         throw new \Exception('aaaa');
        //     }
        // }
        if ($node->nodeName === 'slot') {
            if (!$result->name) {
                $result->name = 'default';
            }
        }
        
        return $result;
    }
    
    public static function isComponent($node)
    {
        if (!@$node->nodeName) {
            return null;
        }
        if ($node->nodeName === 'component') {
            $attrs = self::getNodeAttributes($node);
            if (isset($attrs['is'])) {
                return $attrs['is'];
            }
            return null;
        }

        return Config::getComponentByAlias($node->nodeName);
    }
    
    public function removeNodeAttributes($node, $all = true)
    {
        // remove all attrs, or all special project attrs
    }
    
    public static function arrayToEval(array $arr, $unescape = ':')
    {
        if (!$arr) {
            return '[]';
        }
        $isAssoc = array_keys($arr) !== range(0, count($arr) - 1);
        if (!$isAssoc) {
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