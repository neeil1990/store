<?php


namespace App\Lib\Moysklad\Receive;


use App\Lib\Moysklad\MojSkladJsonApi;

class MyStoreEmployee implements MyStoreReceiveInterface
{
    protected $api;

    public function __construct()
    {
        $this->api = new MojSkladJsonApi;
        $this->api->send('https://api.moysklad.ru/api/remap/1.2/entity/employee');
    }

    public function getRows(): array
    {
        return $this->api->getRows();
    }

    public function currentPage(): int
    {
        return 0;
    }

    public function nextPage(): bool
    {
        return false;
    }
}
