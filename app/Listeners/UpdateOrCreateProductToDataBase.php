<?php

namespace App\Listeners;

use App\Lib\Sale\StoreProductToDataBase;
use App\Models\Products;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        (new StoreProductToDataBase(new Products()))->updateOrCreate($products);
    }
}
