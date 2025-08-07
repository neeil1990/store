<?php

namespace App\Services;

use App\Services\BundleService;
use Illuminate\Support\Arr;

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

    public function getTotalSell(string $uuid, string $dateFrom)
    {
        $selling = 0;

        $bundles = (new BundleService())->getBundleByProduct($uuid);

        $uuids = Arr::pluck($bundles, 'uuid');

        $uuids[] = $uuid;

        foreach ($uuids as $uuid) {
            $profit = $this->getProfitByProduct($uuid, $dateFrom);

            if ($profit) {
                $selling += $profit[0]['sellQuantity'];
            }
        }

        return $selling;
    }
}
