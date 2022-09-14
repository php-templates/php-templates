<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class AttributeManager extends DomNodeAttr
{
    private static $candidates = [];
    
    private $groups = [];
    
    public function __construct(array $preset = []) 
    {
        if (is_null(self::$candidates)) {
            self::$candidates = $this->globAttributes();
        }
        
        foreach ($preset as $attr) {
            $this->add($attr);
        }
    }
    
    public function add(DomNodeAttr $attr) 
    {
        foreach (self::$candidates as $candidate) {
            if (!$candidate::test($attr)) {
                continue;
            }

            $attr = new $candidate($attr);
            if (($k = $attr->getNodeName()) && isset($this->groups[$k])) {
                $this->groups[$k]->add($attr);
            } 
            elseif ($k) {
                $this->groups[$k] = new AttributeGroup([$attr]);
            } else {
                $this->groups[] = $attr; // case @php @ndphp, p-raw -> ignore them or trigger error on components
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
            if (in_array($entity, ['AttributeManager', 'AbstractAttribute', 'AttributeGroup'])) {
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
        
        return ' '.implode(' ', $arr);
    }

    public function toArrayString()
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->toArrayString();
        }
        
        return '[' . implode(', ', $arr) . ']';
    }
}