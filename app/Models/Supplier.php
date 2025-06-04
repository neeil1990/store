<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeWithShippers(Builder $query): void
    {
        $query->leftJoin('shippers', 'suppliers.id', '=', 'shippers.supplier_id')
            ->select(
                'suppliers.*',
                'shippers.id as shipper_id',
                'shippers.name as shipper_name',
                'shippers.email as shipper_email',
                'shippers.plan_fix_email as shipper_plan_fix_email',
                'shippers.plan_fix_link as shipper_plan_fix_link',
                'shippers.comment as shipper_comment',
                'shippers.min_sum as shipper_min_sum',
                'shippers.fill_storage as shipper_fill_storage',
                'shippers.filter_id as shipper_filter_id',
            );
    }
}
