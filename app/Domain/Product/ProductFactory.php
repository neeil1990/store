<?php


namespace App\Domain\Product;

use App\Models\Products;

class ProductFactory
{
    public function makeFromModel(Products $product): Product
    {
        $obj = new Product(
            $product->id,
            $product->name,
            $product->minimumBalance,
            $product->attributes,
        );

        $obj->setStock($product->stock ?? 0);

        $obj->setToBuy($product->toBuy ?? 0);

        return $obj;
    }
}
