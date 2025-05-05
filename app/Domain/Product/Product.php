<?php


namespace App\Domain\Product;

class Product
{
    public ?int $id;
    public ?int $minimumBalance = 0;
    public ?int $stock = 0;
    public ?int $to_buy = 0;

    public float $buyPrice = 0;
    public ?string $name;

    public array $attributes = [];

    public function __construct(int $id, string $name, ?int $minimumBalance, array $attributes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->attributes = $attributes;
        $this->minimumBalance = $minimumBalance;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function setToBuy(int $to_buy): void
    {
        $this->to_buy = $to_buy;
    }

    public function hasBalance(): bool
    {
        return $this->minimumBalance > 0;
    }

    public function setBuyPrice(float $buyPrice): void
    {
        $this->buyPrice = $buyPrice;
    }

    public function totalBuyPrice(): float
    {
        if ($this->to_buy > 0) {
            return $this->buyPrice * $this->to_buy;
        }

        return 0;
    }
}
