<?php


namespace App\Lib\Moysklad\Receive;

use Illuminate\Support\Sleep;

abstract class MyStoreReceive implements MyStoreReceiveInterface
{
    protected $api;

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

    abstract protected function eventClass($rows);

    public function event(): void
    {
        $rows = $this->getRows();

        while($rows)
        {
            $page = $this->currentPage();

            // Pause every 40 request
            if($page > 0 && $page % 40 === 0)
                Sleep::for(1)->seconds();

            $this->eventClass($rows);

            if($this->nextPage()){
                $rows = $this->getRows();
            }else
                $rows = null;
        }
    }
}
