<?php


namespace App\Domain\Shipper;


use App\Domain\Product\Product;
use App\Models\Filter;
use App\Models\Supplier;
use Illuminate\Support\Arr;

class Shipper
{
    public int $quantity = 0;

    public array $products = [];
    public array $users = [];
    public array $storages = [];

    private ?Filter $filter;

    public function __construct(
        public ?int $id,
        public Supplier $supplier,
        public ?string $uuid,
        public ?string $origin_name,
        public ?string $name,
        public ?string $email,
        public ?string $plan_fix_email,
        public ?string $plan_fix_link,
        public ?string $comment,
        public float $min_sum,
        public int $fill_storage,
        public ?int $filter_id
    ) {}

    public function getShipperId(): ?int
    {
        return $this->id;
    }

    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    public function getSupplierId(): int
    {
        $supplier = $this->getSupplier();

        return $supplier->id;
    }

    public function setFilter(?Filter $filter): void
    {
        $this->filter = $filter;
    }

    public function setProducts($products): void
    {
        $this->products = $products;
    }

    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    public function setStorages(array $stores): void
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
        return $this->filter_id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOldName(): ?string
    {
        return $this->origin_name;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function getMinSum(): float
    {
        return $this->min_sum;
    }

    public function getFillStorage(): int
    {
        return $this->calculateFillStorage($this->totalStockProducts());
    }

    public function getFillStorageByStorages(): int
    {
        $storages = $this->getStockByStorages();

        return $this->calculateFillStorage(array_sum(Arr::pluck($storages, 'quantity')));
    }

    private function calculateFillStorage($sum): int
    {
        $balance = $this->totalMinBalanceProducts();

        if ($balance > 0) {
            return round(($sum / $balance) * 100);
        }

        return 0;
    }
}
