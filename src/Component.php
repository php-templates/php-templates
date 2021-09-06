<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Template;

class Component extends Parser
{
    private static $index = 0;
    public static function resetId()
    {
        self::$index = 0;
    }
    
    private $uid = 0;
    private $name;
    private $data;
    private $slots;
    
    public function __construct()
    {
        $this->uid = self::index++;
    }
    
    public function getId()
    {
        return $this->uid;
    }
    
    // mount the slot on specific dom
    public function mount(Template $root)
    {
        // montam datele pe Template::data
        $root->addData($this->getVariableName(), $this->data);
        // daca exista si un parser, cream si entries pe replaces, html string
        if ($root->p)
    }
    
    private function getVariableName()
    {
        return $this->name . $this->uid;
    }
    
    public function getHash()
    {
        $hash = self::getUpdatedAt($this->getSrcFile()).$this->uid;
        foreach ($this->slots as $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                if ($slot instanceof self) {
                    $hash .= $slot->getHash();
                } 
                else {
                    throw new Exception('Non component detected');
                }
            }
        }
    
        return substr(md5($hash, true), 0, 12);
    }
}