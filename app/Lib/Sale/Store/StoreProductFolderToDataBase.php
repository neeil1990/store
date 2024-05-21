<?php


namespace App\Lib\Sale\Store;


class StoreProductFolderToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $item): array
    {
        $item['uuid'] = $item['id'];

        return $item;
    }

    protected function externalCode(array $item): array
    {
        return ['externalCode' => $item['externalCode']];
    }
}
