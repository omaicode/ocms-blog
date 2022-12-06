<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Modules\Blog\Repositories\CategoryRepository::class, \Modules\Blog\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\Modules\Blog\Repositories\PostRepository::class, \Modules\Blog\Repositories\PostRepositoryEloquent::class);
        //:end-bindings:
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
