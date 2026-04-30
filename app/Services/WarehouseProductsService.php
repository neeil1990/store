<?php

namespace App\Services;

use App\Models\Products;

class WarehouseProductsService
{
    /**
     * Get sum of a specific field for warehouse products with stocks
     *
     * @param string $field The field name to sum
     * @return float|int
     */
    public function getSumByField(string $field): float|int
    {
        return Products::where('is_warehouse_item', true)
            ->has('stocks')
            ->sum($field);
    }

    /**
     * Get total purchase price for warehouse products with stocks
     *
     * @return float|int
     */
    public function getTotalPurchasePrice(): float|int
    {
        return $this->getSumByField('buyPrice');
    }

    /**
     * Get total sale price for warehouse products with stocks
     *
     * @return float|int
     */
    public function getTotalSalePrice(): float|int
    {
        return $this->getSumByField('salePrices');
    }

    /**
     * Get total minimum price for warehouse products with stocks
     *
     * @return float|int
     */
    public function getTotalMinPrice(): float|int
    {
        return $this->getSumByField('minPrice');
    }

    /**
     * Get sum of prices by name for warehouse products with stocks
     *
     * @param string $priceName The price name to sum
     * @return float|int
     */
    public function getSumPriceByName(string $priceName): float|int
    {
        return Products::where('is_warehouse_item', true)
            ->has('stocks')
            ->join('prices', 'products.id', '=', 'prices.product_id')
            ->where('prices.name', $priceName)
            ->sum('prices.value');
    }
}
