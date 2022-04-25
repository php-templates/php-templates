<?php

namespace PhpTemplates\Integrations\Laravel;

use PhpTemplates\Template;

class ViewFactory implements \Illuminate\Contracts\View\Factory
{
    private $sharedData = [];
    private $template;
    
    public function __construct($laravel)
    {
        $this->template = new Template(config('view.paths.0'), config('view.compiled'));
        $this->template->replacePath('errors', 'eee');
    }
    
    /**
     * Determine if a given view exists.
     *
     * @param  string  $view
     * @return bool
     */
    public function exists($view)
    {
        return true;
    }

    /**
     * Get the evaluated view contents for the given path.
     *
     * @param  string  $path
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    public function file($path, $data = [], $mergeData = [])
    {
        dd(11);
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    public function make($view, $data = [], $mergeData = [])
    {
        $view = new View($this->template, $view);
        return $view->with(array_merge($this->sharedData, $data));
    }

    /**
     * Add a piece of shared data to the environment.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function share($key, $value = null)
    {
        if (is_array($key)) {
            $this->sharedData = array_merge($this->sharedData, $value);
        } else {
            $this->sharedData[$key] = $value;
        }
    }

    /**
     * Register a view composer event.
     *
     * @param  array|string  $views
     * @param  \Closure|string  $callback
     * @return array
     */
    public function composer($views, $callback)
    {
        //
    }

    /**
     * Register a view creator event.
     *
     * @param  array|string  $views
     * @param  \Closure|string  $callback
     * @return array
     */
    public function creator($views, $callback)
    {
        //
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return $this
     */
    public function addNamespace($namespace, $hints)
    {
        if (in_array($namespace, ['errors'])) {
            $hints[1] = __DIR__ . '/views';
        }
 
        $this->template->addPath($namespace, $hints);
    }

    /**
     * Replace the namespace hints for the given namespace.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return $this
     */
    public function replaceNamespace($namespace, $hints)
    {
        if (in_array($namespace, ['errors'])) {
            $hints[1] = __DIR__ . '/views';
        }
        $this->template->replacePath($namespace, $hints);
    }
    
    public function __call($m, $args)
    {
        if (method_exists($this->template, $m)) {
            return call_user_func_array([$this->template, $m], $args);
        }//flushFinderCache
    }
}