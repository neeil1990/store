<?php

namespace App\Http\Controllers;

use App\Lib\Sale\ProductsTable;
use App\Models\Products;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function show(Products $product)
    {
        $stocks = [
            3 => stockZeros($product, 3),
            5 => stockZeros($product, 5),
            7 => stockZeros($product, 7),
            15 => stockZeros($product, 15),
            30 => stockZeros($product, 30),
            60 => stockZeros($product, 60),
            90 => stockZeros($product, 90),
        ];

        $stores = $this->stores($product);

        $total = [
            'stocks' => $stores->pluck('stocks')->flatten()->sum('quantity'),
            'reserves' => $stores->pluck('reserves')->flatten()->sum('quantity'),
            'transits' => $stores->pluck('transits')->flatten()->sum('quantity'),
        ];

        return view('products.show', compact('product', 'stores', 'total', 'stocks'));
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

    private function stores(Products $product)
    {
        $stores = Store::all()->load([
            'stocks' => function ($query) use ($product) { return $query->product($product); },
            'reserves' => function ($query) use ($product) { return $query->product($product); },
            'transits' => function ($query) use ($product) { return $query->product($product); },
        ])->filter(function($value) {
            return $value['stocks']->isNotEmpty() || $value['reserves']->isNotEmpty() || $value['transits']->isNotEmpty();
        });

        return $stores;
    }

    public function minimumBalanceLagerStore(Request $request)
    {
        $product = Products::find($request['id']);
        $product->minimumBalanceLager = $request['val'];
        return $product->save();
    }
}
