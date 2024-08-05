<?php

namespace App\Providers;

use App\Events\MyStoreProductFolderRowsReceived;
use App\Events\MyStoreProductRowsReceived;
use App\Events\MyStoreStockRowsReceived;
use App\Events\MyStoreSupplierRowsReceived;
use App\Listeners\createStockToDataBase;
use App\Listeners\UpdateOrCreateProductFolderToDataBase;
use App\Listeners\UpdateOrCreateProductsToDataBase;
use App\Listeners\UpdateOrCreateStockToDataBase;
use App\Listeners\UpdateOrCreateSupplierToDataBase;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MyStoreProductRowsReceived::class => [
            UpdateOrCreateProductsToDataBase::class,
        ],
        MyStoreSupplierRowsReceived::class => [
            UpdateOrCreateSupplierToDataBase::class,
        ],
        MyStoreProductFolderRowsReceived::class => [
            UpdateOrCreateProductFolderToDataBase::class,
        ],
        MyStoreStockRowsReceived::class => [
            CreateStockToDataBase::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
