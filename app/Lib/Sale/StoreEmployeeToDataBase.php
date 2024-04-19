<?php


namespace App\Lib\Sale;

class StoreEmployeeToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $item): array
    {
        $item['uuid'] = $item['id'];

        return $item;
    }
}
