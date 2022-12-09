<?php

namespace Islomzoda\YandexMarketUpdateStock;

use Illuminate\Support\ServiceProvider;
use Islomzoda\YandexMarketUpdateStock\Command\GetMatchFromYandexMarketCommand;
use Islomzoda\YandexMarketUpdateStock\Command\ImportAliasCommand;

class YandexMarketUpdateStockServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'islomzoda');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'islomzoda');
         $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/yandexmarketupdatestock.php', 'yandexmarketupdatestock');

        // Register the service the package provides.
        $this->app->singleton('yandexmarketupdatestock', function ($app) {
            return new YandexMarketUpdateStock;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['yandexmarketupdatestock'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/yandexmarketupdatestock.php' => config_path('yandexmarketupdatestock.php'),
        ], 'yandexmarketupdatestock.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/islomzoda'),
        ], 'yandexmarketupdatestock.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/islomzoda'),
        ], 'yandexmarketupdatestock.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/islomzoda'),
        ], 'yandexmarketupdatestock.views');*/

        // Registering package commands.
         $this->commands([ImportAliasCommand::class, GetMatchFromYandexMarketCommand::class]);
    }
}
