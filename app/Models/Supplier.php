<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplier extends Model
{
    protected $guarded = [
        'id',
        'meta',
        'owner',
        'group',
    ];

    use HasFactory;

    public function shipper(): HasOne
    {
        return $this->hasOne(Shipper::class);
    }
}
