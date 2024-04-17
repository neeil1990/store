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

    public function scopeSearchCol(Builder $query, array $search): void
    {

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
}
