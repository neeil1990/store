<?php


namespace App\Lib\Sale;

use App\Events\MyStoreRowsProductReceived;
use App\Lib\Moysklad\Receive\MyStoreEmployee;
use \App\Lib\Moysklad\Receive\MyStoreProducts;
use App\Models\Employee;
use Illuminate\Support\Sleep;

class SyncMyStoreWithDataBase
{
    public function syncAll()
    {
        $this->productSync();
        $this->employeeSync();
    }

    public function employeeSync()
    {
        $employee = (new MyStoreEmployee())->getRows();
        (new StoreEmployeeToDataBase(new Employee()))
            ->updateOrCreate($employee);
    }

    public function productSync()
    {
        $response = new MyStoreProducts();
        $rows = $response->getRows();

        while($rows)
        {
            $page = $response->currentPage();

            // Pause every 40 request
            if($page > 0 && $page % 40 === 0)
                Sleep::for(1)->seconds();

            MyStoreRowsProductReceived::dispatch($rows);

            if($response->nextPage()){
                $rows = $response->getRows();
            }else
                $rows = null;
        }
    }
}
