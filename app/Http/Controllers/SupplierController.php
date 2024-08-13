<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Store;
use DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $store = Store::all();

        return view('suppliers.index', compact('store'));
    }

    public function json()
    {
        $model = new Products();

        $stores = request('stores', []);

        return DataTables::eloquent($model->suppliersDataTable($stores))
            ->toJson();
    }
}
