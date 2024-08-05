<?php

namespace App\Lib\Sale\Store;


use Illuminate\Database\Eloquent\Model;

class StoreStockToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $item): array
    {
        $item['product'] = $this->getIdFromMetaHref($item['product']['href']);

        return $item;
    }

    protected function saveResult(Model $model, array $item): void
    {
        // TODO: Implement saveResult() method.
    }

    protected function externalCode(array $item): array
    {
        // TODO: Implement externalCode() method.
    }
}
