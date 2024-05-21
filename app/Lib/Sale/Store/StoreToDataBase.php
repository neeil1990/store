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
            $obj = $this->model->updateOrCreate($this->externalCode($item), $this->prepareProduct($item));
            $this->saveResult($obj, $item);
        }
    }

    abstract protected function prepareProduct(array $item): array;

    abstract protected function externalCode(array $item): array;

    abstract protected function saveResult(Model $model, array $item): void;

    protected function pennyToRuble(float $price)
    {
        return round($price / 100, 2);
    }
}
