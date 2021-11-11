<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Facades\Config;

class Helper {
    public static function getTemplateName()
    {
        
    }
    
    public function getNodeAttributes($node, $reset = 0) {
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
    
    public function getClassifiedNodeAttributes($node, $reset = 0) {
        $attrs = [
            'c_structs' => [],
            'is' => '',
            'attrs' => [],
            'slot' => 'default',
            'name' => 'default',
        ];
        
        foreach (self::getNodeAttributes($node, $reset) as $attr => $value) {
            if ($attr === 'is') {
                $attrs['is'] = $value;
            } 
            elseif ($attr === 'slot') {
                $attrs['slot'] = $value;
            }
            elseif ($node->nodeName === 'slot' && $attr === 'name') {
                $attrs['name'] = $value;
            }
            elseif (in_array($attr, Config::allowedControlStructures)) {
                $attrs['c_structs'][$attr] = $value;
            }
            elseif (in_array($attr, Config::attrCumulative) && !empty($attrs['attrs'][$attr])) {
                $attrs['attrs'][$attr] .= ' '.$value;
            } else {
                $attrs['attrs'][$attr] = $value;
            }
        }
        
        return $attrs;
    }
    
    public static function isComponent($node)
    {
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
    
    public function arrayToEval(array $array, $unescape = ':')
    {
        $stream = [];
        foreach ($array as $key => $value) {
            if ($key === 'data') {
                continue; // gasim o solutie.. merge, ceva
            }
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