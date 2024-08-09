<?php


namespace App\Models\LocalScopes;


use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProductsScopes extends Model
{
    public function scopeInnerJoinStocks(Builder $query): void
    {
        $query->join('stocks', 'products.uuid', 'stocks.product')
            ->select('products.*', DB::raw('SUM(stocks.stock) as stocks'), DB::raw('SUM(stocks.reserve) as reserve'), DB::raw('SUM(stocks.inTransit) as inTransit'))
            ->groupBy('products.id')
            ->havingRaw('minimumBalance - stocks > 0');
    }

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
}
