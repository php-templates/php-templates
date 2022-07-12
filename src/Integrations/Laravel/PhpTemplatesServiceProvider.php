<?php

namespace PhpTemplates\Integrations\Laravel;

use Illuminate\Support\ServiceProvider;

class PhpTemplatesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('view', function($app) {
            return new ViewFactory($app);
        });
    }
}
