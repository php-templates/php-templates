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
    private $requestName;
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
        if (!$root->parser) {
            // my job is done;
            return;
        }
        
        
    }
    
    private function getVariableName()
    {
        return $this->name . $this->uid;
    }
    
    public function getHash()
    {
        $hash = self::getUpdatedAt($this->getSrcFile()).$this->uid;
        foreach ($this->slots as $n => $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                if ($slot instanceof self) {
                    $hash .= $n.$slot->getHash();
                } 
                else {
                    throw new Exception('Non component detected');
                }
            }
        }
    
        return substr(md5($hash, true), 0, 12);
    }
}