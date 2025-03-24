<?php


namespace App\Helpers;

use App\Models\Products;

class ProductHelper
{
    public static function getPackSize(Products $product): int
    {
        $size = 0;

        $attribute = self::getAttribute($product, 'name', 'Значение кол-ва в упаковке для товаров которые принимают поштучно');

        if ($attribute) {
            $size = $attribute['value'];
        }

        return $size;
    }

    public static function getAttribute(Products $product, string $key, string $value)
    {
        return collect($product->attributes)->firstWhere($key, $value);
    }
}
