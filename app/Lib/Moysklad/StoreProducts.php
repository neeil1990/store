<?php


namespace App\Lib\Moysklad;


class StoreProducts extends StoreRequest
{
    protected $href = 'https://api.moysklad.ru/api/remap/1.2/entity/product';

    public function getProducts()
    {
        return $this->send($this->href)->getResponse();
    }

    public function getProductById(int $id)
    {
        $href = implode('/', [$this->href, $id]);

        return $this->send($href)->getResponse();
    }

    public function setHref(string $href): void
    {
        $this->href = $href;
    }



}
