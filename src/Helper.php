<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Facades\Config;

class Helper {
    public static function getTemplateName()
    {
        
    }
    
    public function getNodeAttributes($node) {
        $attrs = [];
        foreach ($node->attributes ?? [] as $attr) {
            $attrs[$attr->nodeName] = $attr->nodeValue;
        }
        return $attrs;
    }
    
    public function getClassifiedNodeAttributes($node) {
        $attrs = [
            'c_structs' => [],
            'is' => '',
            'attrs' => [],
            'slot' => 'default',
        ];
        
        foreach (self::getNodeAttributes($node) as $attr => $value) {
            if ($attr === 'is') {
                $attrs['is'] = $value;
            } 
            elseif ($attr === 'slot') {
                $attrs['slot'] = $value;
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

        return Config::get('aliased.'.$node->nodeName);
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