<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Filter extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function scopeActive(Builder $query, $status = true)
    {
        $query->where('active', $status);
    }
}
