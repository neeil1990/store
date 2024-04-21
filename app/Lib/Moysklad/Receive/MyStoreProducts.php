<?php


namespace App\Lib\Moysklad\Receive;

use App\Lib\Moysklad\MojSkladJsonApi;

class MyStoreProducts implements MyStoreReceiveInterface
{
    protected $api;

    public function __construct()
    {
        $this->api = new MojSkladJsonApi;
        $this->api->send('https://api.moysklad.ru/api/remap/1.2/entity/product');
    }

    public function getRows(): array
    {
        return $this->api->getRows();
    }

    public function currentPage(): int
    {
        $meta = $this->api->getMeta();

        if(array_key_exists('offset', $meta) && array_key_exists('limit', $meta))
            return ($meta['offset'] / $meta['limit']);

        return 0;
    }

    public function nextPage(): bool
    {
        $meta = $this->api->getMeta();
        if(array_key_exists('nextHref', $meta)){
            $this->api->send($meta['nextHref']);

            return true;
        }

        return false;
    }
}
