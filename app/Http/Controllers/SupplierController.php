<?php

namespace App\Http\Controllers;

use App\DataTables\SuppliersDataTable;
use App\Exports\SuppliersExport;
use App\Models\Products;
use App\Models\Store;


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

        $export = request('exports', []);
        $stores = request('stores', []);

        $dataTable = new SuppliersDataTable($model->suppliersDataTable($stores));

        if ($export) {
            return new SuppliersExport($dataTable->getCollection());
        }

        return $dataTable->getJson();
    }
}
