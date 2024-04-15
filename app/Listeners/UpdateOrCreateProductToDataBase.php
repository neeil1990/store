<?php

namespace App\Listeners;

use App\Lib\Sale\StoreProductToDataBase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateOrCreateProductToDataBase implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $products = $event->products;
        (new StoreProductToDataBase())->updateOrCreate($products);
    }
}
