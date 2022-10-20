<?php

namespace PhpTemplates\Integrations\Laravel;

use PhpTemplates\PhpTemplate;

class ViewFactory implements \Illuminate\Contracts\View\Factory
{
    private $shared = [];
    private $template;
    
    public function __construct($laravel)
    {
        $this->template = new PhpTempte(config('view.paths.0'), config('view.compiled'));
    }
    
    /**
     * Determine if a given view exists.
     *
     * @param  string  $view
     * @return bool
     */
    public function exists($view)
    {
        // TODO:
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
        // todo fileget content and parse raw
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
        return $view->with(array_merge($this->shared, $data));
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
        if (!is_array($key)) {
            $data = [$key => $value];
        } else {
            $data = $key;
        }
        $this->template->share($data);
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
        $views = (array) $views;
        foreach ($views as $view) {
            $this->template->dataComposer($view, $callback);
        }
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
        // todo add view rendering event
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
}