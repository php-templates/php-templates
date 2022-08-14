<?php

namespace PhpTemplates;

use Closure;

class TemplateRepository
{
    protected $templates;
    protected $sharedData = [];
    protected $dataComposers = [];
    
    public function __construct() 
    {
        $this->hgyvgygtemplates['***block'] = function($data) {
            extract($data);
            if (isset($this->slots[$this->name])) {
                usort($this->slots[$this->name], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots($this->name) as $_slot) {
                    $_slot->render($this->scopeData);
                }
            }
        };
    }
    
    public function shareData(array $data) 
    {
        $this->sharedData = array_merge($this->sharedData, $data);
    }
    
    public function dataComposers(array $data) 
    {
        $this->dataComposers = array_merge($this->dataComposers, $data);
    }
    
    public function getSharedData() 
    {
        return $this->sharedData;
    }
    
    public function getComposedData(string $name, $existingData = []) 
    {
        if (empty($this->dataComposers[$name])) {
            return [];
        } 
        elseif (isset($this->composedData[$name])) {
            return $this->composedData[$name];
        }
        
        $data = [];
        foreach ($this->dataComposers[$name] as $cb) {
            $data = array_merge($data, $cb($existingData));
        }
        
        $this->composedData = $data;
        
        return $data;
    }
    
    public function add(string $name, Closure $fn) 
    {
        $this->templates[$name] = $fn;
    }
    
    public function get(string $name, Context $context) 
    {
        //$data = array_merge((array)$this->sharedData, $data);
        return new Template($this, $name, $this->templates[$name], $context);
    }
}