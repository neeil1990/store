<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use App\Models\Supplier;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
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

        return view('dashboard', compact('usersCount', 'productsCount', 'suppliersCount', 'outOfStockCount'));
    }
}
