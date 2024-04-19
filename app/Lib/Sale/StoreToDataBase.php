<?php


namespace App\Lib\Sale;


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
            $this->model->updateOrCreate(['externalCode' => $item['externalCode']], $this->prepareProduct($item));
    }

    abstract protected function prepareProduct(array $item): array;
}
