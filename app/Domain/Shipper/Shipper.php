<?php


namespace App\Domain\Shipper;


use App\Domain\Product\Product;

class Shipper
{
    public int $quantity = 0;

    public array $products = [];
    public array $users = [];

    public function __construct(
        public ?int $id,
        public ?int $supplier_id,
        public ?string $uuid,
        public ?string $origin_name,
        public ?string $name,
        public ?string $email,
        public ?string $plan_fix_email,
        public ?string $plan_fix_link,
        public ?string $comment,
        public ?string $min_sum,
        public ?string $fill_storage
    ) {}

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function addUsers(array $users): void
    {
        $this->users = $users;
    }

    public static function isAvailableShipper(): array
    {
        return ['name' => 'Складская позиция', 'value' => true];
    }

    public function quantity(): int
    {
        return count(array_filter($this->products, function (Product $product) {
            return $product->hasBalance();
        }));
    }

    public function totalToBuy(): int
    {
        return array_sum(array_map(function (Product $product) {
            return max(0, $product->to_buy);
        }, $this->products));
    }

    public function buyPrice(): float
    {
        $sum = array_map(function (Product $product) {
            return $product->totalBuyPrice();
        }, $this->products);

        return round(array_sum($sum), 2);
    }

    public function totalStockProducts(): int
    {
        $stock = 0;

        foreach ($this->products as $product) {
            $stock += $product->stock;
        }

        return $stock;
    }

    public function totalMinBalanceProducts(): int
    {
        $balance = 0;

        foreach ($this->products as $product) {
            $balance += $product->minimumBalance;
        }

        return $balance;
    }

    public function fillPercent(): float
    {
        $stock = $this->totalStockProducts();
        $balance = $this->totalMinBalanceProducts();

        if ($balance > 0) {
            return round(($stock / $balance) * 100, 2);
        }

        return 0;
    }
}
