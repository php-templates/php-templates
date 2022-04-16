<?php

namespace PhpTemplates\Integrations\Laravel;

class View implements \Illuminate\Contracts\View\View
{
    private $engine;
    private $name;
    private $data = [];
    
    public function __construct($engine, $name) {
        $this->engine = $engine;
        $this->name = $name;
    }
    
    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Add a piece of data to the view.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * Get the array of view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        ob_start();
        $this->engine->load($this->name, $this->data);
        $content = ob_get_contents();
        ob_clean();
        
        return $content;
    }
}