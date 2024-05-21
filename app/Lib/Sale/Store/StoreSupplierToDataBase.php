<?php


namespace App\Lib\Sale\Store;

class StoreSupplierToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $item): array
    {
        $item['uuid'] = $item['id'];
        $item['salesAmount'] = $this->pennyToRuble($item['salesAmount']);

        return $item;
    }

    protected function externalCode(array $item): array
    {
        return ['externalCode' => $item['externalCode']];
    }
}
