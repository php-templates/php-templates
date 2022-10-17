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
            if (!trim($attr->nodeName) && !trim($attr->nodeValue)) {
                debug_print_backtrace(2);die();
            }
            $group = new $candidate();
            $group->add($attr);// aici
            $k = $group->getNodeName();
            if (!$k) { // solo group
                $this->groups[] = $group;
            } elseif (isset($this->groups[$k])) {
                $this->groups[$k]->add($attr);
            } else {
                $this->groups[$k] = $group;
            }
            break;
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

        usort($entities, function ($b, $a) {
            return $a::WEIGHT - $b::WEIGHT;
        });

        return $entities;
    }

    public function __toString()
    {
        foreach ($this->groups as $group) {
            if ($group instanceof BindArrayAttributeGroup) {
                return $this->bindArrayToNode();
            }
        }

        return $this->bindToNodeAttr();

        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->stringContext();
        }

        return implode(' ', $arr);
    }

    public function toArrayString()
    {
        foreach ($this->groups as $group) {
            if ($group instanceof BindArrayAttributeGroup) {
                return $this->bindArrayToTemplate();
            }
        }

        return $this->bindToTemplateAttr();
    }

    private function bindToTemplateAttr()
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->bindToTemplateAttr();
        }

        return '[' . implode(', ', $arr) . ']';
    }

    private function bindToNodeAttr()
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->bindToNodeAttr();
        }

        return implode(' ', $arr);
    }

    private function bindArrayToNode()
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->bindArrayToNode();
        }

        return '<?php bind(attr_merge(' . implode(', ', $arr) . ')); ?>';
    }

    private function bindArrayToTemplate()
    {
        $arr = [];
        foreach ($this->groups as $group) {
            $arr[] = $group->bindArrayToTemplate();
        }

        return 'array_merge(' . implode(', ', $arr) . ')';
    }
}
