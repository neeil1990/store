<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    protected $guarded = [
        'stock'
    ];

    use HasFactory;

    public function store()
    {
        return $this->belongsTo(Store::class, 'storeId', 'uuid');
    }

    public function scopeProduct(Builder $query, Products $product)
    {
        $query->where('assortmentId', $product['uuid']);
    }

    public function scopeSum(Builder $query): void
    {
        $query->select('assortmentId', DB::raw('SUM(quantity) stock'))->groupBy('assortmentId');
    }
}
