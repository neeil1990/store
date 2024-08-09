<?php


namespace App\Lib\Moysklad\Receive;

use App\Events\MyStoreStockRowsReceived;
use App\Lib\Moysklad\MojSkladJsonApi;

class MyStoreStock extends MyStoreReceive
{
    public function __construct()
    {
        $this->api = new MojSkladJsonApi;
        $this->api->send('https://api.moysklad.ru/api/remap/1.2/report/stock/bystore?filter=stockMode=all');
    }

    protected function eventClass($rows)
    {
        MyStoreStockRowsReceived::dispatch($rows);
    }
}
