<?php


namespace App\Lib\Sale\Store;


class StoreGroupToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $item): array
    {
        $item['uuid'] = $item['id'];

        return $item;
    }

    protected function externalCode(array $item): array
    {
        return ['uuid' => $item['id']];
    }
}
