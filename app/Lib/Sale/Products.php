<?php


namespace App\Lib\Sale;

use App\Events\ProductArrayReceived;
use \App\Lib\Moysklad\StoreProducts;
use Illuminate\Support\Sleep;

class Products
{
    public function syncAll()
    {
        $response = new StoreProducts();
        $products = $response->getProducts();

        while($products)
        {
            $page = ($products['meta']['offset'] / $products['meta']['limit']);

            // Pause every 40 request
            if($page > 0 && $page % 40 === 0)
                Sleep::for(1)->seconds();

            ProductArrayReceived::dispatch($products['rows']);

            if(isset($products['meta']['nextHref'])){
                $response->setHref($products['meta']['nextHref']);
                $products = $response->getProducts();
            }else
                $products = null;
        }
    }
}
