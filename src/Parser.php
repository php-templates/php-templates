<?php

namespace HarmonyTools;

class Parser
{
    private $options = [
        
    ];
    
    private $data;
    private $slots;
    
    publoc function __construct(string $srcFile, array $data = [], array $slots = [], array $options = [])
    {
        parent::construct($srcFile);
        
        // set slots set data, if q slots, set ukey then as name in slot
        // add slots too
        $this->setSlots($slots);
    }
    
    public function parse()
    {
        //check if any dynamic slots and parse file for dynamic slots query and replace them with uniq name
        
        // parse this file, and foreach found slot call load m
        foreach if tag name slot check in slots
        slot will be a string as result of load with o to return string
        if slot has data, replace slot with closure function if slot has slots, f will be unique, k => val
        if slot has no data, replace slot with uname and k val global
          foreach slots slots, call load
          
    }
    
    private function prepareSlots()
    {
        foreach ($this->slots as $name => $slot) {
            if (!is_array($slot) && !selfnslot type) {
                throw 'Slots must be instances of x or array of instances of x';
            }
            $_slots = (array) $slot;
            foreach ($_slots as $s) {
                if (not instance of self $s) {
                    throw 'ArraySlots must contain only instances of x';
                }
            }
            if (strpos($name, 'q:')) {
                // is query slot
                $this->addDynamicSlot($slot);
                unset($this->slots[$name]);
            }
        }
        
        public function addDynamicSlot($slot)
        {
            
        }
    }
}