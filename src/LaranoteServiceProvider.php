<?php

namespace BinaryCats\Laranote;

use Illuminate\Support\AggregateServiceProvider as ServiceProvider;

class LaranoteServiceProvider extends ServiceProvider
{
    /**
     * Location of the provider
     *
     * @var string
     */
    protected $path = __DIR__;

    /**
     * Name of the package
     *
     * @var string
     */
    protected $name = 'laranote';

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        Providers\RequestMacros::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig()
             ->publishMigrations()
             ->publishViews();
    }

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig()->mergeViews();

        parent::register();
    }

    /**
     * Merge the config for the repo
     *
     * @return $this
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom("{$this->path}/../config/{$this->name}.php", $this->name);

        return $this;
    }

    /**
     * Merge the config for the repo
     *
     * @return $this
     */
    protected function mergeViews()
    {
        $this->loadViewsFrom("{$this->path}/../resources/views", $this->name);

        return $this;
    }

    /**
     * Publish config for the repo
     *
     * @return $this
     */
    protected function publishConfig()
    {
        $this->publishes([
            "{$this->path}/../config/{$this->name}.php" => config_path("{$this->name}.php")
        ], 'config');

        return $this;
    }

    /**
     * Publish Migrations, Seeders and Factories
     *
     * @return $this
     */
    protected function publishMigrations()
    {
        $this->publishes([
            "{$this->path}/../database" => database_path(),
        ], 'migrations');

        return $this;
    }

    /**
     * Publish Views
     *
     * @return $this
     */
    protected function publishViews()
    {
        $this->publishes([
            "{$this->path}/../resources/views" => resource_path("views/{$this->name}"),
        ], 'views');
    }
}
