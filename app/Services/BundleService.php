<?php

namespace App\Services;

use App\Lib\Moysklad\Receive\MyStoreBundle;

class BundleService
{
    private array $bundle = [];

    public function __construct()
    {
        $this->bundle = (new MyStoreBundle())->allRows();
    }

    public function getBundle(): array
    {
        return $this->bundle;
    }

    public function getBundleByProduct(string $uuid): array
    {
        $result = [];

        $bundle = $this->getBundle();

        foreach ($bundle as $item) {
            foreach ($item['components']['rows'] as $row) {
                if ($row['assortment']['id'] === $uuid) {
                    $result[$item['id']] = $item;
                }
            }
        }

        return $result;
    }
}
