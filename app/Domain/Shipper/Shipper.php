<?php


namespace App\Domain\Shipper;


use App\Domain\Product\Product;
use App\Models\Filter;

class Shipper
{
    public int $quantity = 0;

    public array $products = [];
    public array $users = [];
    public array $storages = [];

    private ?Filter $filter;

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

    public function setFilter(?Filter $filter): void
    {
        $this->filter = $filter;
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function addUsers(array $users): void
    {
        $this->users = $users;
    }

    public function addStorages(array $stores): void
    {
        $this->storages = $stores;
    }

    public function getStorages(): ?array
    {
        return $this->storages;
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
            return $product->calculateQuantityToBuy();
        }, $this->products));
    }

    public function buyPrice(): float
    {
        $sum = array_map(function (Product $product) {
            return $product->totalBuyPrice();
        }, $this->products);

        return round(array_sum($sum), 2);
    }

    public function getStockByStorages(): array
    {
        $stocks = [];

        $storages = $this->getStorages();

        foreach ($storages as $storage) {
            $stocks[] = [
                'uuid' => $storage->uuid,
                'name' => $storage->name,
                'quantity' => $this->totalStockProducts([$storage->uuid])
            ];
        }

        return $stocks;
    }

    public function totalStockProducts(array $storages = []): int
    {
        $stock = 0;

        /** @var Product $product */
        foreach ($this->products as $product) {
            $stock += $product->totalStock($storages);
        }

        return $stock;
    }

    public function totalMinBalanceProducts(): int
    {
        $balance = 0;

        /** @var Product $product */
        foreach ($this->products as $product) {
            $balance += $product->minimumBalance();
        }

        return $balance;
    }

    public function filter(): array
    {
        $filter = [
            'description' => '',
            'error' => '',
            'params' => [],
        ];

        if (!$this->filter) {
            $filter['error'] = __('Фильтр не найден');
        }

        if (!$filter['error']) {
            $filter['description'] = implode(': ', [$this->getFilterName(), $this->getFilterUserName()]);
            $filter['params'] = $this->getFilterParams();
        }

        return $filter;
    }

    public function getFilterId(): ?int
    {
        return $this->filter?->id;
    }

    public function getFilterName(): ?string
    {
        return $this->filter?->name;
    }

    public function getFilterUserName(): ?string
    {
        return $this->filter?->user->name;
    }

    public function getFilterParams(): ?array
    {
        return json_decode($this->filter?->payload, true);
    }

    public function generateSuppliersExportLink(): ?string
    {
        $params = $this->getFilterParams();

        if (!$params) {
            return null;
        }

        unset($params['length']);

        $params['exports'] = 'suppliers';
        $params['toBuy'] = true;

        return implode('?', [route('suppliers.json'), http_build_query(convertBoolToStrings($params))]);
    }

    public function generateBuyersExportLink(): ?string
    {
        $params = $this->getFilterParams();

        if (!$params) {
            return null;
        }

        unset($params['length']);

        $params['exports'] = 'buyers';

        return implode('?', [route('suppliers.json'), http_build_query(convertBoolToStrings($params))]);
    }
}
