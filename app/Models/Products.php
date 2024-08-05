<?php

namespace App\Models;

use App\Lib\Main\RegExWrapper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function scopeSelectEmployee(Builder $query)
    {
        $query->addSelect(['owner' => Employee::select('name')->whereColumn('uuid', 'products.owner')->limit(1)]);
    }

    protected function stockTotal(): Attribute
    {
        return Attribute::make(function(){
            return $this->stocks->pluck('stock')->sum();
        });
    }

    protected function paymentItemType(): Attribute
    {
        return Attribute::make(function($value){
            switch ($value) {
                case "GOOD":
                    return __('Товар');
                    break;
                case "EXCISABLE_GOOD":
                    return __('Подакцизный товар');
                    break;
                case "COMPOUND_PAYMENT_ITEM":
                    return __('Составной предмет расчета');
                    break;
                case "ANOTHER_PAYMENT_ITEM":
                    return __('Иной предмет расчета');
                    break;
                default:
                    return "";
            }
        });
    }

    protected function trackingType(): Attribute
    {
        return Attribute::make(function($value){
            $types = [
                "BEER_ALCOHOL" => "Пиво и слабоалкогольная продукция",
                "ELECTRONICS" => "Фотокамеры и лампы-вспышки",
                "FOOD_SUPPLEMENT" => "Биологически активные добавки к пище",
                "LP_CLOTHES" => "Тип маркировки Одежда",
                "LP_LINENS" => "Тип маркировки Постельное белье",
                "MILK" => "Молочная продукция",
                "NCP" => "Никотиносодержащая продукция",
                "NOT_TRACKED" => "Без маркировки",
                "OTP" => "Альтернативная табачная продукция",
                "PERFUMERY" => "Духи и туалетная вода",
                "SANITIZER" => "Антисептики",
                "SHOES" => "Тип маркировки Обувь",
                "TIRES" => "Шины и покрышки",
                "TOBACCO" => "Тип маркировки Табак",
                "WATER" => "Упакованная вода",
            ];

            if(array_key_exists($value, $types))
                return $types[$value];
            else
                return "";
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'owner', 'uuid')->withDefault(['name' => 'Не выбран']);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(ProductFolder::class, 'productFolder', 'uuid')->withDefault(['name' => 'Не выбран']);
    }

    public function suppliers(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'uuid')->withDefault(['name' => 'Не выбран']);
    }

    public function countries(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country', 'uuid')->withDefault(['name' => 'Не выбран']);
    }

    public function uoms(): BelongsTo
    {
        return $this->belongsTo(Uom::class, 'uom', 'uuid')->withDefault(['name' => 'Не выбран']);
    }

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group', 'uuid')->withDefault(['name' => 'Не выбран']);
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product', 'uuid');
    }
}
