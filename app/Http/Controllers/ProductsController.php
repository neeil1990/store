<?php

namespace App\Http\Controllers;

use App\Lib\Sale\ProductsTable;
use App\Models\Products;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function outOfStock(Request $request)
    {
        $products = Products::with(['suppliers', 'stocks'])
            ->whereJsonContains('attributes', ['name' => 'Складская позиция', 'value' => true])
            ->whereJsonContains('attributes', ['name' => 'Перестали сотрудничать / Не производится (дет.в комментах)', 'value' => false])
            ->withCount([
                'stockTotal as stock_zero_3' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(3)),
                'stockTotal as stock_zero_5' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(5)),
                'stockTotal as stock_zero_7' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(7)),
                'stockTotal as stock_zero_15' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(15)),
                'stockTotal as stock_zero_30' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(30)),
                'stockTotal as stock_zero_60' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(60)),
                'stockTotal as stock_zero_90' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(90)),
                'stockTotal as stock_zero_180' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(180)),
                'stockTotal as stock_zero_365' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(365)),
            ])
            ->when($request->input('isZero'), fn ($q) => $q->doesntHave('stocks'))
            ->get();

        return view('products.out-of-stock', compact('products'));
    }

}
