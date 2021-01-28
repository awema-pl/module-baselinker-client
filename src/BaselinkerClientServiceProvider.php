<?php

namespace AwemaPL\BaselinkerClient;

use AwemaPL\BaselinkerClient\User\Sections\Accounts\Models\Account;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Repositories\Contracts\AccountRepository;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Repositories\EloquentAccountRepository;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Policies\AccountPolicy;
use AwemaPL\BaselinkerClient\Admin\Sections\Settings\Repositories\Contracts\SettingRepository;
use AwemaPL\BaselinkerClient\Admin\Sections\Settings\Repositories\EloquentSettingRepository;
use AwemaPL\BaseJS\AwemaProvider;
use AwemaPL\BaselinkerClient\Listeners\EventSubscriber;
use AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Middleware\GlobalMiddleware;
use AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Middleware\GroupMiddleware;
use AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Middleware\Installation;
use AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Middleware\RouteMiddleware;
use AwemaPL\BaselinkerClient\Contracts\BaselinkerClient as BaselinkerClientContract;
use Illuminate\Support\Facades\Event;
use AwemaPL\BaselinkerClient\Client\Api\Services\Orders\GetAllFromDateOrdersAsArray;
use AwemaPL\BaselinkerClient\Client\Api\Services\Orders\Contracts\GetAllFromDateOrdersAsArray as GetAllFromDateOrdersAsArrayContract;
use AwemaPL\BaselinkerClient\Client\Api\Services\Storages\GetAllProductsQuantityAsArray;
use AwemaPL\BaselinkerClient\Client\Api\Services\Storages\Contracts\GetAllProductsQuantityAsArray as GetAllProductsQuantityAsArrayContract;

class BaselinkerClientServiceProvider extends AwemaProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Account::class => AccountPolicy::class,
    ];

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'baselinker-client');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'baselinker-client');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->bootMiddleware();
        app('baselinker-client')->includeLangJs();
        app('baselinker-client')->menuMerge();
        app('baselinker-client')->mergePermissions();
        $this->registerPolicies();
        Event::subscribe(EventSubscriber::class);
        parent::boot();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/baselinker-client.php', 'baselinker-client');
        $this->mergeConfigFrom(__DIR__ . '/../config/baselinker-client-menu.php', 'baselinker-client-menu');
        $this->app->bind(BaselinkerClientContract::class, BaselinkerClient::class);
        $this->app->singleton('baselinker-client', BaselinkerClientContract::class);
        $this->registerRepositories();
        $this->registerServices();
        parent::register();
    }


    public function getPackageName(): string
    {
        return 'baselinker-client';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    /**
     * Register and bind package repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->app->bind(AccountRepository::class, EloquentAccountRepository::class);
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
    }

    /**
     * Register and bind package services
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->bind(GetAllFromDateOrdersAsArrayContract::class, GetAllFromDateOrdersAsArray::class);
        $this->app->bind(GetAllProductsQuantityAsArrayContract::class, GetAllProductsQuantityAsArray::class);
    }


    /**
     * Boot middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootMiddleware()
    {
        $this->bootGlobalMiddleware();
        $this->bootRouteMiddleware();
        $this->bootGroupMiddleware();
    }

    /**
     * Boot route middleware
     */
    private function bootRouteMiddleware()
    {
        $router = app('router');
        $router->aliasMiddleware('baselinker-client', RouteMiddleware::class);
    }

    /**
     * Boot grEloquentAccountRepositoryoup middleware
     */
    private function bootGroupMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->appendMiddlewareToGroup('web', GroupMiddleware::class);
        $kernel->appendMiddlewareToGroup('web', Installation::class);
    }

    /**
     * Boot global middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootGlobalMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(GlobalMiddleware::class);
    }
}
