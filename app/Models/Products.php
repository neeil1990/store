<?php

namespace App\Models;

use App\Models\LocalScopes\ProductsScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Products extends ProductsScopes
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
        'deleted_stock_total_at' => 'datetime',
    ];

    use HasFactory;

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('d.m.Y H:i');
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
        return $this->hasMany(Stock::class, 'assortmentId', 'uuid');
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class, 'assortmentId', 'uuid');
    }

    public function transits()
    {
        return $this->hasMany(Transit::class, 'assortmentId', 'uuid');
    }

    public function stockTotal()
    {
        return $this->hasMany(StockTotal::class, 'assortmentId', 'uuid');
    }

    protected function userWhoDeletedStockTotal(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $user = User::find($value);

                if ($user) {
                    return $user->name;
                }

                return null;
            },
        );
    }
}
