<?php


namespace App\Lib\Moysklad;


class StoreProducts extends StoreRequest
{
    public function __construct()
    {
        $this->href = 'https://api.moysklad.ru/api/remap/1.2/entity/product';
    }

    public function getApi(): array
    {
        return $this->send()->getResponse();
    }
}
