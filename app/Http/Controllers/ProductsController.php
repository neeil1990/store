<?php

namespace App\Http\Controllers;

use App\Lib\Sale\ProductFrontend;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function json(Request $request)
    {
        $products = new ProductFrontend($request->all());

        return collect([
            'draw' => $request->input('draw'),
            'recordsTotal' => $products->total(),
            'recordsFiltered' => $products->records(),
            'data' => $products->items(),
            'error' => $products->error(),
        ]);
    }
}
