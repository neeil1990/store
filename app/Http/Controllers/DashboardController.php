<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Products;
use App\Models\Shipper;
use App\Models\Supplier;
use App\Models\User;
use App\Services\DataOutputCache;
use App\Services\ProductCountHistoryService;
use App\Services\WarehouseProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(ProductCountHistoryService $productCountHistoryService, WarehouseProductsService $warehouseProductsService)
    {
        $chartDays = 30;

        if (! DataOutputCache::enabled()) {
            $stats = $this->buildDashboardIndexStats($productCountHistoryService, $warehouseProductsService, $chartDays);
        } else {
            $identity = DataOutputCache::normalizeForKey(['chart_days' => $chartDays]);
            $stats = DataOutputCache::remember(
                DataOutputCache::REVISION_DASHBOARD_SUMMARY,
                DataOutputCache::SEGMENT_DASHBOARD_INDEX_STATS,
                $identity,
                null,
                fn () => $this->buildDashboardIndexStats($productCountHistoryService, $warehouseProductsService, $chartDays)
            );
            if (! is_array($stats)) {
                $stats = $this->buildDashboardIndexStats($productCountHistoryService, $warehouseProductsService, $chartDays);
            }
        }

        return view('dashboard', $stats);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildDashboardIndexStats(
        ProductCountHistoryService $productCountHistoryService,
        WarehouseProductsService $warehouseProductsService,
        int $chartDays
    ): array {
        $usersCount = User::where('is_archived', false)->count();
        $productsCount = Products::count();

        $availableShippersIds = Products::select('supplier')
            ->whereNotNull('supplier')
            ->where('is_warehouse_item', true)
            ->groupBy('supplier')
            ->pluck('supplier');

        $suppliersCount = Supplier::whereIn('uuid', $availableShippersIds)->count();

        $outOfStockCount = Products::doesntHave('stocks')->count();

        $warehouseProductsCount = Products::where('is_warehouse_item', true)->has('stocks')->count();

        $purchasePriceSum = $warehouseProductsService->getTotalPurchasePrice();
        $salePriceSum = $warehouseProductsService->getTotalSalePrice();
        $minPriceSum = $warehouseProductsService->getTotalMinPrice();

        $totalPurchaseSum = Shipper::sum('calc_purchase_total');

        $productDynamicsData = $productCountHistoryService->getChartData($chartDays);

        $priceNames = $this->getPriceNames()->values()->all();

        return compact(
            'usersCount',
            'productsCount',
            'suppliersCount',
            'outOfStockCount',
            'warehouseProductsCount',
            'purchasePriceSum',
            'salePriceSum',
            'minPriceSum',
            'totalPurchaseSum',
            'productDynamicsData',
            'priceNames'
        );
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
    public function getPriceSumByName(Request $request, WarehouseProductsService $warehouseProductsService): JsonResponse
    {
        $priceName = (string) $request->input('price_name', '');

        if ($priceName === '') {
            return response()->json(['error' => 'Price name is required'], 422);
        }

        if (! DataOutputCache::enabled()) {
            return response()->json($this->buildPriceSumPayload($warehouseProductsService, $priceName));
        }

        $identity = DataOutputCache::normalizeForKey([
            'price_name' => $priceName,
            '_uid' => Auth::id(),
        ]);
        $payload = DataOutputCache::remember(
            DataOutputCache::REVISION_INVENTORY,
            DataOutputCache::SEGMENT_DASHBOARD_PRICE_SUM,
            $identity,
            null,
            fn () => $this->buildPriceSumPayload($warehouseProductsService, $priceName)
        );

        return response()->json(is_array($payload) ? $payload : [
            'sum' => 0,
            'formatted_sum' => money(0),
            'price_name' => $priceName,
        ]);
    }

    /**
     * @return array{sum: float|int, formatted_sum: string, price_name: string}
     */
    private function buildPriceSumPayload(WarehouseProductsService $warehouseProductsService, string $priceName): array
    {
        $sum = $warehouseProductsService->getSumPriceByName($priceName);

        return [
            'sum' => $sum,
            'formatted_sum' => money($sum),
            'price_name' => $priceName,
        ];
    }
}
