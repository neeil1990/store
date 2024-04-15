<?php


namespace App\Lib\Sale;


use App\Models\Products;

class StoreProductToDataBase
{
    public function updateOrCreate(array $products)
    {
        foreach ($products as $product)
            Products::updateOrCreate(['externalCode' => $product['externalCode']], $this->prepareProduct($product));
    }

    protected function prepareProduct($product)
    {
        $product['uuid'] = $product['id'];

        if(isset($product['owner']))
            $product['owner'] = $this->getIdFromMetaHref($product['owner']['meta']['href']);

        if(isset($product['group']))
            $product['group'] = $this->getIdFromMetaHref($product['group']['meta']['href']);

        if(isset($product['productFolder']))
            $product['productFolder'] = $this->getIdFromMetaHref($product['productFolder']['meta']['href']);

        $product['minPrice'] = $this->pennyToRuble($product['minPrice']['value']);
        $product['salePrices'] = (isset($product['salePrices'][0])) ? $this->pennyToRuble($product['salePrices'][0]['value']) : 0.0;
        $product['buyPrice'] = $this->pennyToRuble($product['buyPrice']['value']);

        return $product;
    }

    private function getIdFromMetaHref(string $href)
    {
        return substr($href, strrpos($href, '/') + 1);
    }

    private function pennyToRuble(float $price)
    {
        return round($price / 100, 2);
    }
}
