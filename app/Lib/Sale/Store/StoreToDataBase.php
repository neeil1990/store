<?php


namespace App\Lib\Sale\Store;


use Illuminate\Database\Eloquent\Model;

abstract class StoreToDataBase
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function updateOrCreate(array $items)
    {
        foreach ($items as $item)
        {
            $this->model->updateOrCreate($this->externalCode($item), $this->prepareProduct($item));
        }
    }

    abstract protected function prepareProduct(array $item): array;

    abstract protected function externalCode(array $item): array;

    protected function pennyToRuble(float $price)
    {
        return round($price / 100, 2);
    }
}
