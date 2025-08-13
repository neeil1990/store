<?php

namespace App\Http\Controllers;

use App\Lib\Sale\ProductsTable;
use App\Models\Products;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Коэффициент пополнения
        $replenishmentCoefficient = 1.5;

        // Дней отсутствия за 30 дней
        $product->loadCount(['stockTotal as unavailable_days_count' => function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }]);

        // Продажи за 30 дней
        $product->loadSum('lastSell as last_sell_sum', 'sell');

        // Средний спрос
        $middleSupply = round($product->last_sell_sum / (30 - $product->unavailable_days_count), 2);

        // Базовый запас для редких товаров
        $baseStock = ($product->last_sell_sum <= 1) ? 2 : 0;

        // Неснижаемый остаток
        $minimumBalance = ($product->last_sell_sum * $replenishmentCoefficient) + ($product->unavailable_days_count * $middleSupply) + $baseStock;

        $salesFormula = [
            'replenishmentCoefficient' => $replenishmentCoefficient, // Коэффициент пополнения
            'unavailable_days_count' => $product->unavailable_days_count, // Дней отсутствия за 30 дней
            'last_sell_sum' => $product->last_sell_sum, // Продажи за 30 дней
            'middleSupply' => $middleSupply, // Средний спрос
            'baseStock' => $baseStock, // Базовый запас для редких товаров
            'minimumBalance' => $minimumBalance // Неснижаемый остаток
        ];

        return view('products.show', compact('product', 'stores', 'total', 'stocks', 'salesFormula'));
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
        $products = Products::getOutOfStock($request->input('isZero'));

        return view('products.out-of-stock', compact('products'));
    }

    public function destroyStockTotals(Request $request)
    {
        $products = Products::whereIn('id', $request->input('ids', []))->get();

        foreach ($products as $product) {
            if ($product->stockTotal->toQuery()->delete()) {
                $product->update([
                    'user_who_deleted_stock_total' => Auth::id(),
                    'deleted_stock_total_at' => Carbon::now()
                ]);
            }
        }
    }

}
