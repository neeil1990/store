<?php

namespace App\Http\Controllers;

use App\Lib\Sale\ProductsTable;
use App\Models\Products;
use App\Models\Setting;
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

        $salesFormula = $product->sales_formula;

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

    public function multiplicityStore(Request $request)
    {
        $product = Products::find($request['id']);

        $product->multiplicityProduct = $request['val'];

        return $product->save();
    }

    public function outOfStock(Request $request)
    {
        $filter = $request->input('filter');
        $products = Products::getOutOfStock($filter);

        $filterLabels = [
            'zero' => 'Показать нулевые',
            'multiplicity' => 'Без кратности товара',
        ];

        $title = '';

        if ($filter && isset($filterLabels[$filter])) {
            $title = ' - ' . $filterLabels[$filter];
        }

        $settings = $this->outOfStockSettings();

        return view('products.out-of-stock', compact('products', 'title', 'settings'));
    }

    private function outOfStockSettings(): array
    {
        $settings = [
            ['key' => 'replenishmentCoefficient', 'title' => 'Коэффициент пополнения', 'hint' => ''],
            ['key' => 'baseStock', 'title' => 'Базовый запас для редких товаров', 'hint' => ''],
            ['key' => 'baseStockPrice', 'title' => 'Базовый запас для редких товаров стоимостью выше 50 000 (Цена для маркетов)', 'hint' => ''],
            ['key' => 'baseStockOverprice', 'title' => 'Базовый запас для редких товаров стоимостью выше 50 000 (Значение)', 'hint' => ''],
            ['key' => 'maxMinimumBalance', 'title' => 'Коэффициент максимального изменения предлагаемого остатка', 'hint' => ''],
            ['key' => 'salesFormulaDays', 'title' => 'Анализируем отсутствие товара за дней', 'hint' => ''],
            ['key' => 'salesFormulaDaysSell', 'title' => 'Анализируем продажи за дней (Диапазон продаж 15 дней. 1 = 15, 2 = 30... 3 * 15 дней)', 'hint' => ''],
        ];

        foreach ($settings as &$setting) {
            $setting['hint'] = \App\Models\Description::getByKey($setting['title'], '');
        }

        return $settings;
    }

    public function destroyStockTotals(Request $request)
    {
        $products = Products::whereIn('id', $request->input('ids', []))->get();

        foreach ($products as $product) {
            if ($product->stockTotal->isNotEmpty() && $product->stockTotal->toQuery()->delete()) {
                $product->update([
                    'user_who_deleted_stock_total' => Auth::id(),
                    'deleted_stock_total_at' => Carbon::now()
                ]);
            }
        }
    }

    public function storeOutOfStockSettings(Request $request)
    {
        $values = [
            'value' => $request->input('value', 0)
        ];

        if (!$values['value']) {
            $values['value'] = 0;
        }

        Setting::query()->updateOrCreate(['key' => $request->input('key')], $values);
    }

    public function getOutOfStockSettings(string $key)
    {
        return Setting::query()->where('key', $key)->value('value');
    }

}
