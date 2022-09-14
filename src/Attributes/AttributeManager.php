<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

class AttributeManager extends DomNodeAttr
{
    private static $candidates;
    
    private $attrs = [];
    
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
            if ($candidate::test($attr)) {
                $attr = new $candidate($attr);
                if (($k = $attr->getNodeName()) && isset($this->attrs[$k])) {
                    $this->attrs[$k]->add($attr);
                } 
                elseif ($k) {
                    $this->attrs[$k] = new AttributeGroup([$attr]);
                } else {
                    $this->attrs[] = $attr; // case @php @ndphp, p-raw -> ignore them or trigger error on components
                }
                break;
            }
        }
    }
    
    private function globAttributes() 
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
        
        $this->entities = $entities;
    }
    
    public function __toString() 
    {
        $arr = [];
        foreach ($this->attrs as $attr) {
            $arr[] = $attr->toString();
        }
        
        return ' '.implode(' ', $arr);
    }
}