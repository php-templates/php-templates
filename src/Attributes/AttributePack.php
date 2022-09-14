<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class AttributePack extends DomNodeAttr
{
    private static $candidates;
    
    private $groups = [];
    
    public function __construct() 
    {
        if (is_null(self::$candidates)) {
            self::$candidates = $this->globAttributes();
        }
    }
    
    public function add(DomNodeAttr $attr) 
    {
        foreach (self::$candidates as $candidate) {
            if (!$candidate::test($attr)) {
                continue;
            }

            $group = new $candidate();
            $group->add($attr);
            $k = $group->getNodeName();
            if (isset($this->groups[$k])) {
                $this->groups[$k]->add($attr);
            } 
            else {
                $this->groups[$k] = $group;
            }    
        }
    }
    
    private function globAttributes(): array
    {
        $files = array_filter(glob(__DIR__ . '/*'), 'is_file');
        
        $entities = [];
        foreach ($files as $file) {
            $entity = preg_split('/(\\/|\\\)/', $file);
            $entity = str_replace('.php', '', end($entity));
            if (in_array($entity, ['AttributePack', 'AbstractAttributeGroup'])) {
                continue;
            }
            $entity = '\\PhpTemplates\\Attributes\\' . $entity;
            $entities[] = $entity;
        }
        
        usort($entities, function($b, $a) {
            return $a::WEIGHT - $b::WEIGHT;
        });
        
        return $entities;
    }
    
    public function __toString() 
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->toString();
        }
        
        if (!$arr) {
            return '';
        }
        
        return ' '.implode(' ', $arr);
    }

    public function toArrayString()
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->toArrayString();
        }
        //$arr && dd($arr);
        
        return '[' . implode(', ', $arr) . ']';
    }
}