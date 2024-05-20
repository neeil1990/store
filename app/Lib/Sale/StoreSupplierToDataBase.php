<?php


namespace App\Lib\Sale;

class StoreSupplierToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $item): array
    {
        $item['uuid'] = $item['id'];
        $item['salesAmount'] = $this->pennyToRuble($item['salesAmount']);

        return $item;
    }
}
