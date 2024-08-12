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
        if(count($value) > 0)
        {
            $search = [];

            foreach ($value as $item)
            {
                if(array_key_exists('col', $item) && array_key_exists('val', $item) && strlen($item['val']) > 0)
                    $search[] = [$item['col'], 'like', $item['val'] . '%'];
            }

            if(count($search) > 0)
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

    public function scopeSuppliersDataTable(Builder $query)
    {
        $query->select('products.*', 'stocks.stock', 'reserves.reserve', 'transits.transit')
            ->joinSub((new Stock())->sum(), 'stocks', function($join){
                $join->on('products.uuid', '=', 'stocks.assortmentId');
            })
            ->leftJoinSub((new Reserve())->sum(), 'reserves', function($join){
                $join->on('products.uuid', '=', 'reserves.assortmentId');
            })
            ->leftJoinSub((new Transit())->sum(), 'transits', function($join){
                $join->on('products.uuid', '=', 'transits.assortmentId');
            })
            ->whereRaw('minimumBalance - stock > ?', [0]);
    }
}
