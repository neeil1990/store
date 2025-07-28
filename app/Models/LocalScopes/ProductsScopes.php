<?php


namespace App\Models\LocalScopes;

use App\Models\Employee;
use App\Models\Reserve;
use App\Models\Stock;
use App\Models\Transit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductsScopes extends Model
{
    public function scopeSearchCols(Builder $query, array $value): void
    {
        if (count($value) > 0) {
            $search = [];

            foreach ($value as $item) {
                if (array_key_exists('col', $item) && array_key_exists('val', $item) && strlen($item['val']) > 0)
                    $search[] = [$item['col'], 'like', $item['val'] . '%'];
            }

            if (count($search) > 0)
                $query->where($search);
        }
    }

    public function scopeOrderCol(Builder $query, string $col = 'name', string $dir = 'asc'): void
    {
        $query->orderBy($col, $dir);
    }

    public function scopeSelectEmployee(Builder $query)
    {
        $query->addSelect(['owner' => Employee::select('name')->whereColumn('uuid', 'products.owner')->limit(1)]);
    }

    public function scopeSuppliersDataTable(Builder $query, array $stores = [])
    {
        $query->with(['suppliers', 'uoms'])
            ->select('products.*', 'stocks.stock', 'reserves.reserve', 'transits.transit')
            ->addSelectToBuy()
            ->addStockPercent()
            ->leftJoinSub((new Stock())->sum($stores), 'stocks', function ($join) {
                $join->on('products.uuid', '=', 'stocks.assortmentId');
            })
            ->leftJoinSub((new Reserve())->sum($stores), 'reserves', function ($join) {
                $join->on('products.uuid', '=', 'reserves.assortmentId');
            })
            ->leftJoinSub((new Transit())->sum($stores), 'transits', function ($join) {
                $join->on('products.uuid', '=', 'transits.assortmentId');
            });
    }

    public function scopeinStock(Builder $query)
    {
        $query->whereRaw('IFNULL(stock, 0) > ?', [0]);
    }

    public function scopeIsWarehousePosition(Builder $query)
    {
        $query->whereJsonContains('attributes', ['name' => 'Складская позиция', 'value' => true]);
    }

    public function scopeAddSelectToBuy(Builder $query)
    {
        $query->selectRaw('IFNULL(products.minimumBalanceLager, IFNULL(products.minimumBalance, 0)) - ((IFNULL(stocks.stock, 0) - IFNULL(reserves.reserve, 0)) + IFNULL(transits.transit, 0)) as toBuy');
    }

    public function scopeAddStockPercent(Builder $query)
    {
        $minimumBalance = 'IFNULL(products.minimumBalanceLager, IFNULL(products.minimumBalance, 0))';
        $a = '(IFNULL(stocks.stock, 0) + IFNULL(transits.transit, 0) - IFNULL(reserves.reserve, 0))';
        $b = "($minimumBalance / 100)";

        $query->selectRaw("$a DIV $b as stockPercent");
    }
}
