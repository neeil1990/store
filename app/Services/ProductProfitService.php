<?php

namespace App\Services;

class ProductProfitService
{

    public function getProfitByProduct(string $uuid, string $date): array
    {
        $api = new \App\Lib\Moysklad\MojSkladJsonApi;

        $endpoint = 'https://api.moysklad.ru/api/remap/1.2/report/profit/byproduct';

        $api->send($endpoint, [
            'filter' => "product=https://api.moysklad.ru/api/remap/1.2/entity/product/$uuid",
            'momentFrom' => $date
        ]);

        return $api->getRows();
    }
}
