<?php

namespace App\Models;

use App\Lib\Main\RegExWrapper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Products extends Model
{
    protected $guarded = [
        'id',
        'meta',
        'files',
    ];

    protected $casts = [
        'barcodes' => 'array',
        'attributes' => 'array',
        'images' => 'array',
    ];

    use HasFactory;

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('d.m.Y H:i');
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

    public function scopeSearchEachWordInLine(Builder $query, string $column, string $value): void
    {
        if(strlen($value) > 1)
        {
            $regex = RegExWrapper::beginningOfEachWordInLine($value);

            $query->where($column, 'REGEXP', $regex);
        }
    }

    public function scopeSelectEmployee(Builder $query)
    {
        $query->addSelect(['owner' => Employee::select('name')->whereColumn('uuid', 'products.owner')->limit(1)]);
    }
}
