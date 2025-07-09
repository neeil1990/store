<?php

namespace App\Lib\Moysklad\Receive;

use App\Lib\Moysklad\MojSkladJsonApi;

class MyStoreBundle extends MyStoreReceive
{
    public function __construct()
    {
        $this->api = new MojSkladJsonApi;
        $this->api->send('https://api.moysklad.ru/api/remap/1.2/entity/bundle?expand=components.assortment&limit=100');
    }

    protected function eventClass($rows)
    {
        // TODO: Implement eventClass() method.
    }
}
