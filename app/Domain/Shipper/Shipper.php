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

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
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

    public function isAvailableProducts(): int
    {
        return count(array_filter($this->products, function (Product $product) {
            return $product->isAvailable();
        }));
    }

    public function totalProducts(): int
    {
        return count($this->products);
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

    public function fillPercent(): float
    {
        return round(($this->isAvailableProducts() / $this->totalProducts()) * 100, 2);
    }
}
