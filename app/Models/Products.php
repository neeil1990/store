<?php

namespace App\Models;

use App\Models\LocalScopes\ProductsScopes;
use Carbon\Carbon;
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
        'total_sell' => 'array',
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
        return Attribute::make(function ($value) {
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
        return Attribute::make(function ($value) {
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

            if (array_key_exists($value, $types))
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

    public function sell()
    {
        return $this->hasMany(Sell::class, 'product_id');
    }

    public function lastSell()
    {
        return $this->hasOne(Sell::class, 'product_id')->latestOfMany();
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

    public static function getOutOfStock($isZero = null)
    {
        return Products::with(['suppliers', 'stocks'])
            ->whereJsonContains('attributes', ['name' => 'Складская позиция', 'value' => true])
            ->whereJsonContains('attributes', ['name' => 'Перестали сотрудничать / Не производится (дет.в комментах)', 'value' => false])
            ->withCount([
                'stockTotal as stock_zero_3' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(3)),
                'stockTotal as stock_zero_5' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(5)),
                'stockTotal as stock_zero_7' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(7)),
                'stockTotal as stock_zero_15' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(15)),
                'stockTotal as stock_zero_30' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(30)),
                'stockTotal as stock_zero_60' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(60)),
                'stockTotal as stock_zero_90' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(90)),
                'stockTotal as stock_zero_180' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(180)),
                'stockTotal as stock_zero_365' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(365)),
            ])
            ->when($isZero, fn($q) => $q->doesntHave('stocks'))
            ->withSum('stocks', 'quantity')
            ->withSum([
                'sell as sell_15' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(15)),
                'sell as sell_30' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(30)),
                'sell as sell_60' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(60)),
                'sell as sell_90' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(90)),
                'sell as sell_180' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(180)),
                'sell as sell_365' => fn($q) => $q->where('created_at', '>', \Carbon\Carbon::now()->subDays(365)),
            ], 'sell')
            ->get();
    }

    public function getSalesFormula(): array
    {
        // Коэффициент пополнения
        $replenishmentCoefficient = floatval(Setting::query()->where('key', 'replenishmentCoefficient')->value('value') ?? 1.5);

        // Дней отсутствия за 30 дней
        $this->loadCount(['stockTotal as unavailable_days_count' => function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }]);

        // Продажи за 30 дней
        $this->loadSum(['sell as last_sell_sum' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(2);
        }], 'sell');

        // Средний спрос
        $days = 30 - $this->unavailable_days_count;
        if ($days > 0) {
            $middleSupply = round($this->last_sell_sum / $days, 2);
        } else {
            $middleSupply = 0;
        }

        // Базовый запас для редких товаров
        $baseStock = ($this->last_sell_sum <= 1) ? floatval(Setting::query()->where('key', 'baseStock')->value('value') ?? 2) : 0;

        // Базовый запас для редких товаров стоимостью выше 50 000 (Цена)
        $baseStockPrice = intval(Setting::query()->where('key', 'baseStockPrice')->value('value') ?? 50000);

        // Базовый запас для редких товаров стоимостью выше 50 000 (Значение)
        $baseStockOverprice = intval(Setting::query()->where('key', 'baseStockOverprice')->value('value') ?? 1);

        if ($this->prices->where('name', 'Цена Маркеты с теста')->value('value') > $baseStockPrice) {
            $baseStock = $baseStockOverprice;
        }

        // Неснижаемый остаток
        $minimumBalance = round(($this->last_sell_sum * $replenishmentCoefficient) + ($this->unavailable_days_count * $middleSupply) + $baseStock);

        // Значение кол-ва в упаковке для товаров которые принимают поштучно
        $sizePackIndex = collect($this['attributes'])->search(fn ($item) => $item['name'] == 'Значение кол-ва в упаковке для товаров которые принимают поштучно');

        $minimumBalanceInPack = 0;

        if ($sizePackIndex) {
            $minimumBalanceInPack = $minimumBalance * $this['attributes'][$sizePackIndex]['value'];
        }

        return [
            'baseStockPrice' => $baseStockPrice, // Базовый запас для редких товаров стоимостью выше 50 000 (Цена)
            'baseStockOverprice' => $baseStockOverprice, // Базовый запас для редких товаров стоимостью выше 50 000 (Значение)
            'replenishmentCoefficient' => $replenishmentCoefficient, // Коэффициент пополнения
            'unavailable_days_count' => $this->unavailable_days_count, // Дней отсутствия за 30 дней
            'last_sell_sum' => $this->last_sell_sum, // Продажи за 30 дней
            'middleSupply' => $middleSupply, // Средний спрос
            'baseStock' => $baseStock, // Базовый запас для редких товаров
            'minimumBalance' => $minimumBalance, // Неснижаемый остаток
            'minimumBalanceInPack' => $minimumBalanceInPack // Значение кол-ва в упаковке
        ];
    }

    public function salesFormula(): Attribute
    {
        return Attribute::get(fn () => $this->getSalesFormula());
    }

    public function priceAuto(): Attribute
    {
        $priceAutoIndex = collect($this['attributes'])->search(fn ($item) => $item['name'] == 'Автоматизация цены');

        return Attribute::get(fn () => ($priceAutoIndex) ? $this['attributes'][$priceAutoIndex]['value'] : " - ");
    }
}
