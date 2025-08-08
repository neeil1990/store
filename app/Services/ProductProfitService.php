<?php

namespace App\Services;

use App\Services\BundleService;
use Illuminate\Support\Arr;

class ProductProfitService
{
    public function getProfitByProduct(array $uuids, string $date): array
    {
        $api = new \App\Lib\Moysklad\MojSkladJsonApi;

        $endpoint = 'https://api.moysklad.ru/api/remap/1.2/report/profit/byproduct';

        $filter = array_map(function ($uuid) {
            return "product=https://api.moysklad.ru/api/remap/1.2/entity/product/$uuid";
        }, $uuids);

        $api->send($endpoint, [
            'filter' => implode(";", $filter),
            'momentFrom' => $date
        ]);

        return $api->getRows();
    }

    public function getTotalSell(string $uuid, string $dateFrom)
    {
        $bundles = (new BundleService())->getBundleByProduct($uuid);

        $uuids = Arr::pluck($bundles, 'uuid');

        $uuids[] = $uuid;

        $profit = $this->getProfitByProduct($uuids, $dateFrom);

        return array_sum(Arr::pluck($profit, 'sellQuantity'));
    }
}
