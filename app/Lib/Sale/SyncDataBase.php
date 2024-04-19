<?php


namespace App\Lib\Sale;

use App\Events\ProductArrayReceived;
use App\Lib\Moysklad\StoreEmployee;
use \App\Lib\Moysklad\StoreProducts;
use App\Models\Employee;
use Illuminate\Support\Sleep;

class SyncDataBase
{
    public function syncAll()
    {
        $this->productSync();
        $this->employeeSync();
    }

    public function employeeSync()
    {
        $employee = (new StoreEmployee())->getApi();
        (new StoreEmployeeToDataBase(new Employee()))->updateOrCreate($employee['rows']);
    }

    public function productSync()
    {
        $response = new StoreProducts();
        $products = $response->getApi();

        while($products)
        {
            $page = ($products['meta']['offset'] / $products['meta']['limit']);

            // Pause every 40 request
            if($page > 0 && $page % 40 === 0)
                Sleep::for(1)->seconds();

            ProductArrayReceived::dispatch($products['rows']);

            if(isset($products['meta']['nextHref'])){
                $response->setHref($products['meta']['nextHref']);
                $products = $response->getApi();
            }else
                $products = null;
        }
    }
}
