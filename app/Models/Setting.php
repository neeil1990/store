<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Setting extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function scopeToken(Builder $query): void
    {
        $query->where('key', 'token');
    }
}
