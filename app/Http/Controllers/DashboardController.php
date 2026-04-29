<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use App\Models\Supplier;
use App\Services\ProductCountHistoryService;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(ProductCountHistoryService $productCountHistoryService)
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

        // Get product count history for chart
        $productDynamicsData = $productCountHistoryService->getChartData(30);

        return view('dashboard', compact('usersCount', 'productsCount', 'suppliersCount', 'outOfStockCount', 'productDynamicsData'));
    }
}
