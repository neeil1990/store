<?php


namespace App\Domain\Shipper;


use App\Domain\Product\Product;

class Shipper
{
    public ?string $uuid;
    public ?string $origin_name;
    public ?string $name;
    public ?string $email;
    public ?string $plan_fix_email;
    public ?string $plan_fix_link;
    public ?string $comment;

    public ?int $id;
    public ?int $supplier_id;
    public int $quantity = 0;
    public int $min_sum = 0;
    public int $fill_storage = 0;

    public array $products = [];
    public array $users = [];


    public function __construct(
        ?int $id,
        ?int $supplier_id,
        ?string $uuid,
        ?string $origin_name,
        ?string $name,
        ?string $email,
        ?string $plan_fix_email,
        ?string $plan_fix_link,
        ?string $comment,
        ?string $min_sum,
        ?string $fill_storage
    )
    {
        $this->id = $id;
        $this->supplier_id = $supplier_id;
        $this->uuid = $uuid;
        $this->origin_name = $origin_name;
        $this->name = $name;
        $this->email = $email;
        $this->plan_fix_email = $plan_fix_email;
        $this->plan_fix_link = $plan_fix_link;
        $this->comment = $comment;
        $this->min_sum = $min_sum;
        $this->fill_storage = $fill_storage;
    }

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
}
