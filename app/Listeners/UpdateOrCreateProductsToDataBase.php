<?php

namespace App\Listeners;

use App\Lib\Sale\StoreProductToDataBase;
use App\Models\Products;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrCreateProductsToDataBase implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     * @param object $event
     */
    public function handle(object $event): void
    {
        $product = new Products();
        if($event->class == get_class($product))
            (new StoreProductToDataBase($product))
                ->updateOrCreate($event->rows);
    }
}
