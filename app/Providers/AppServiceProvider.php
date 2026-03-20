<?php

namespace App\Providers;

use App\Domain\Product\ProductRepository;
use App\Domain\Shipper\ShipperRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\EloquentProductRepository;
use App\Infrastructure\EloquentShipperRepository;
use App\Infrastructure\EloquentUserRepository;
use App\View\Components\AppLayout;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(ShipperRepository::class, EloquentShipperRepository::class);

        View::composer('*', function ($view) {
            $route = Route::currentRouteName();
            $menu = AppLayout::menuItems();
            $view->with('pageTitle', isset($menu[$route]) ? $menu[$route]['text'] : '');
        });
    }
}
