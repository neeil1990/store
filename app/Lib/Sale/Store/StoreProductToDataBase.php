<?php


namespace App\Lib\Sale\Store;

use App\Models\Price;
use Illuminate\Database\Eloquent\Model;

class StoreProductToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $product): array
    {
        $product['uuid'] = $product['id'];

        foreach (['owner', 'uom', 'group', 'productFolder', 'supplier', 'country'] as $key)
            if(isset($product[$key]))
                $product[$key] = $this->getIdFromMeta($product[$key]);

        $product['minPrice'] = $this->pennyToRuble($product['minPrice']['value']);
        $product['salePrices'] = (isset($product['salePrices'][0])) ? $this->pennyToRuble($product['salePrices'][0]['value']) : 0.0;
        $product['buyPrice'] = $this->pennyToRuble($product['buyPrice']['value']);

        return $product;
    }

    protected function getIdFromMeta(array $field)
    {
        if(!isset($field['meta']))
            return null;

        $href = $field['meta']['href'];

        return substr($href, strrpos($href, '/') + 1);
    }

    protected function externalCode(array $item): array
    {
        return ['externalCode' => $item['externalCode']];
    }

    protected function saveResult(Model $model, array $item): void
    {
        $price = new Price();

        $price->where('product_id', $model['id'])->delete();

        foreach ($item['salePrices'] as $p)
        {
            $price->create([
                'uuid' => $p['priceType']['id'],
                'product_id' => $model['id'],
                'name' => $p['priceType']['name'],
                'value' => $this->pennyToRuble($p['value']),
            ]);
        }
    }
}
