<?php

namespace App\Http\Controllers;

use App\Lib\Sale\ProductsTable;
use App\Models\Attribute;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function show(Products $product)
    {
        return view('products.show', compact('product'));
    }

    public function json(Request $request)
    {
        $products = new ProductsTable($request->all());

        return collect([
            'draw' => $request->input('draw'),
            'recordsTotal' => $products->recordsTotal(),
            'recordsFiltered' => $products->recordsFiltered(),
            'data' => $products->data(),
            'error' => $products->error(),
        ]);
    }
}
