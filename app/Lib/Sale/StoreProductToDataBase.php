<?php


namespace App\Lib\Sale;

class StoreProductToDataBase extends StoreToDataBase
{
    protected function prepareProduct(array $product): array
    {
        $product['uuid'] = $product['id'];

        if(isset($product['owner']))
            $product['owner'] = $this->getIdFromMetaHref($product['owner']['meta']['href']);

        if(isset($product['group']))
            $product['group'] = $this->getIdFromMetaHref($product['group']['meta']['href']);

        if(isset($product['productFolder']))
            $product['productFolder'] = $this->getIdFromMetaHref($product['productFolder']['meta']['href']);

        if(isset($product['supplier']))
            $product['supplier'] = $this->getIdFromMetaHref($product['supplier']['meta']['href']);

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
