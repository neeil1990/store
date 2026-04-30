<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use App\Models\Supplier;
use App\Models\Shipper;
use App\Models\Price;
use App\Services\ProductCountHistoryService;
use App\Services\WarehouseProductsService;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(ProductCountHistoryService $productCountHistoryService, WarehouseProductsService $warehouseProductsService)
    {
        $usersCount = User::where('is_archived', false)->count();
        $productsCount = Products::count();

        // Count suppliers with warehouse items (same filter as /shipper page)
        $availableShippersIds = Products::select('supplier')
            ->whereNotNull('supplier')
            ->where('is_warehouse_item', true)
            ->groupBy('supplier')
            ->pluck('supplier');

        $suppliersCount = Supplier::whereIn('uuid', $availableShippersIds)->count();

        // Count products without stock
        $outOfStockCount = Products::doesntHave('stocks')->count();

        // Count products in stock (warehouse items with stock)
        $warehouseProductsCount = Products::where('is_warehouse_item', true)->has('stocks')->count();

        // Get sum of purchase prices for warehouse products with stocks
        $purchasePriceSum = $warehouseProductsService->getTotalPurchasePrice();

        // Get sum of sale prices for warehouse products with stocks
        $salePriceSum = $warehouseProductsService->getTotalSalePrice();

        // Get sum of minimum prices for warehouse products with stocks
        $minPriceSum = $warehouseProductsService->getTotalMinPrice();

        // Get total purchase sum from all shippers
        $totalPurchaseSum = Shipper::sum('calc_purchase_total');

        // Get product count history for chart
        $productDynamicsData = $productCountHistoryService->getChartData(30);

        // Get all available price names
        $priceNames = $this->getPriceNames();

        return view('dashboard', compact('usersCount', 'productsCount', 'suppliersCount', 'outOfStockCount', 'warehouseProductsCount', 'purchasePriceSum', 'salePriceSum', 'minPriceSum', 'totalPurchaseSum', 'productDynamicsData', 'priceNames'));
    }

    /**
     * Get all available price names
     */
    private function getPriceNames()
    {
        return Price::select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
    }

    /**
     * Get sum of prices by name for AJAX requests
     */
    public function getPriceSumByName(WarehouseProductsService $warehouseProductsService)
    {
        $priceName = request('price_name');

        if (!$priceName) {
            return response()->json(['error' => 'Price name is required'], 422);
        }

        $sum = $warehouseProductsService->getSumPriceByName($priceName);

        return response()->json([
            'sum' => $sum,
            'formatted_sum' => money($sum),
            'price_name' => $priceName
        ]);
    }
}
