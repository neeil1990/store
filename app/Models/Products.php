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

    public static function getOutOfStock($filter = null)
    {
        $now = Carbon::now();

        $stockZeroPeriods = [3, 5, 7, 15, 30, 60, 90, 180, 365];
        $sellPeriods = [15, 30, 60, 90, 180, 365];

        $stockZeroCounts = [];
        foreach ($stockZeroPeriods as $days) {
            $date = $now->copy()->subDays($days);
            $stockZeroCounts["stockTotal as stock_zero_{$days}"] = fn($q) => $q->where('created_at', '>', $date);
        }

        $sellSums = [];
        foreach ($sellPeriods as $days) {
            $date = $now->copy()->subDays($days);
            $sellSums["sell as sell_{$days}"] = fn($q) => $q->where('created_at', '>', $date);
        }

        return Products::with(['suppliers', 'stocks', 'transits'])
            ->selectRaw('
                products.*,
                LEAST(100, ROUND(
                    (SELECT COALESCE(SUM(quantity), 0) FROM stocks WHERE assortmentId = products.uuid)
                    / NULLIF(multiplicityProduct, 0) * 100
                )) as pack_percentage
            ')
            ->where('is_warehouse_item', true)
            ->where('is_discontinued', false)
            ->withCount($stockZeroCounts)
            ->when($filter, function ($query) use ($filter) {
                if ($filter == "zero") {
                    $query->doesntHave('stocks');
                }

                if ($filter == "zero_no_transits") {
                    $query->doesntHave('stocks')->doesntHave('transits');
                }

                if ($filter == "multiplicity") {
                    $query->whereNull('multiplicityProduct');
                }

                if ($filter == "incomplete_pack") {
                    $pack_percentage = intval(Setting::query()->where('key', 'incompletePackPercent')->value('value') ?? 0);

                    $query->whereNotNull('multiplicityProduct')
                        ->where('multiplicityProduct', '>', 0)
                        ->havingRaw('stocks_sum_quantity IS NOT NULL')
                        ->havingRaw('pack_percentage IS NOT NULL AND pack_percentage <= ' . $pack_percentage);
                }
            })
            ->withSum('stocks', 'quantity')
            ->withSum('transits', 'quantity')
            ->withSum($sellSums, 'sell')
            ->get();
    }

    public function getSalesFormula(): array
    {
        // Коэффициент пополнения
        $replenishmentCoefficient = floatval(Setting::query()->where('key', 'replenishmentCoefficient')->value('value') ?? 1.5);

        // Количество дней для расчёта отсутствия
        $salesFormulaDays = intval(Setting::query()->where('key', 'salesFormulaDays')->value('value') ?? 30);

        // Дней отсутствия за $salesFormulaDays дней
		$this->unavailable_days_count = $this->stockTotal->where('created_at', '>=', Carbon::now()->subDays($salesFormulaDays))->count();

        // Количество дней для расчёта продаж
        $salesFormulaDaysSell = intval(Setting::query()->where('key', 'salesFormulaDaysSell')->value('value') ?? 2);

        // Продажи за $salesFormulaDaysSell дней где $salesFormulaDaysSell * 15
		$this->last_sell_sum = $this->sell->sortByDesc("created_at")->take($salesFormulaDaysSell)->sum("sell");

        // Средний спрос
        $days = $salesFormulaDays - $this->unavailable_days_count;

        if ($days > 0) {
            $middleSupply = round($this->last_sell_sum / ($salesFormulaDaysSell * 15), 2);
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

        // Режим экономии
        $economyMode = (bool) Setting::query()->where('key', 'economyMode')->value('value');
        $economyModeApplied = false;
        $economyModeDays = 0;
        $economyModeMaxPercent = 0;
        $economyModeAbsentDays = 0;
        $economyModeMaxAbsentDays = 0;
        $economyModeMinimumBalance = 0;

        if ($economyMode) {
            $economyModeDays = intval(Setting::query()->where('key', 'economyModeDays')->value('value') ?? 90);
            $economyModeMaxPercent = floatval(Setting::query()->where('key', 'economyModeMaxPercent')->value('value') ?? 5);

            $economyModeMaxAbsentDays = floor($economyModeDays * $economyModeMaxPercent / 100);
            $economyModeAbsentDays = $this->stockTotal
                ->where('created_at', '>=', Carbon::now()->subDays($economyModeDays))
                ->count();

            if ($economyModeAbsentDays <= $economyModeMaxAbsentDays) {
                $economyModeApplied = true;
                $economyModeMinimumBalance = round($middleSupply * 30);
                $minimumBalance = $economyModeMinimumBalance;
            }
        }

        // Коэффициент максимального изменения предлагаемого остатка
        $maxMinimumBalance = Setting::query()->where('key', 'maxMinimumBalance')->value('value');

        if ($maxMinimumBalance) {
            $minimumBalance = min($this->minimumBalance * $maxMinimumBalance, $minimumBalance);
        }

        $minimumBalanceBeforeMultiplicity = $minimumBalance;

        // Кратность товара
        $sizePackPercent = 0;

        if ($this->multiplicityProduct) {
            if ($minimumBalance < $this->multiplicityProduct) {
                $minimumBalance = $this->multiplicityProduct;
            } else {
                $sizePackPercent = ($minimumBalance % $this->multiplicityProduct) / $this->multiplicityProduct * 100;

                if ($sizePackPercent > 80) {
                    $minimumBalance = $this->multiplicityProduct * ceil($minimumBalance / $this->multiplicityProduct);
                } else {
                    $minimumBalance = $this->multiplicityProduct * floor($minimumBalance / $this->multiplicityProduct);
                }
            }
        }

        $minimumBalanceBeforeBalanceLager = $minimumBalance;

        // Неснижаемый остаток lager
        if ($this->minimumBalanceLager) {
            $minimumBalance = max($minimumBalance, $this->minimumBalanceLager);
        }

        // Значение кол-ва в упаковке для товаров которые принимают поштучно
        $minimumBalanceInPack = $this->pack_quantity
            ? $minimumBalance * $this->pack_quantity
            : 0;

        return [
            'salesFormulaDaysSell' => $salesFormulaDaysSell, // Количество дней для расчёта продаж
            'salesFormulaDays' => $salesFormulaDays, // Количество дней для расчёта отсутствия
            'baseStockPrice' => $baseStockPrice, // Базовый запас для редких товаров стоимостью выше 50 000 (Цена)
            'baseStockOverprice' => $baseStockOverprice, // Базовый запас для редких товаров стоимостью выше 50 000 (Значение)
            'replenishmentCoefficient' => $replenishmentCoefficient, // Коэффициент пополнения
            'unavailable_days_count' => $this->unavailable_days_count, // Дней отсутствия за 30 дней
            'last_sell_sum' => $this->last_sell_sum, // Продажи за 30 дней
            'middleSupply' => $middleSupply, // Средний спрос
            'baseStock' => $baseStock, // Базовый запас для редких товаров
            'minimumBalance' => $minimumBalance, // Неснижаемый остаток
            'minimumBalanceInPack' => $minimumBalanceInPack, // Значение кол-ва в упаковке
            'maxMinimumBalance' => $maxMinimumBalance, // Коэффициент максимального изменения предлагаемого остатка
            'minimumBalanceBeforeMultiplicity' => $minimumBalanceBeforeMultiplicity, // Кратность товара
            'multiplicity' => $this->multiplicityProduct, // Кратность товара
            'sizePackPercent' => $sizePackPercent, // Кратность товара процент
            'minimumBalanceLager' => $this->minimumBalanceLager, // Неснижаемый остаток lager
            'minimumBalanceBeforeBalanceLager' => $minimumBalanceBeforeBalanceLager, // Неснижаемый остаток до lager

            // Режим экономии
            'economyMode' => $economyMode,
            'economyModeApplied' => $economyModeApplied,
            'economyModeDays' => $economyModeDays,
            'economyModeMaxPercent' => $economyModeMaxPercent,
            'economyModeAbsentDays' => $economyModeAbsentDays,
            'economyModeMaxAbsentDays' => $economyModeMaxAbsentDays,
            'economyModeMinimumBalance' => $economyModeMinimumBalance,
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
