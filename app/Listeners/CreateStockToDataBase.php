<?php

namespace App\Listeners;

use App\Lib\Sale\Store\StoreStockToDataBase;
use App\Models\Stock;
use Illuminate\Contracts\Queue\ShouldQueue;


class CreateStockToDataBase implements ShouldQueue
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
        $store = new StoreStockToDataBase(new Stock());

        foreach ($event->rows as $row)
        {
            foreach ($row["stockByStore"] as &$stockByStore)
            {
                $stockByStore['product'] = $row["meta"];
            }

            $store->create($row["stockByStore"]);
        }
    }
}
