<?php

namespace App\Http\Controllers;

use App\Models\Products;
use DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        return view('suppliers.index');
    }

    public function json()
    {
        $model = new Products();
        $query = $model->innerJoinStocks();

        return DataTables::eloquent($query)
            ->toJson();
    }
}
