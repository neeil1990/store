<?php


namespace App\Lib\Sale;

use App\Events\MyStoreRowsReceived;
use App\Lib\Moysklad\Receive\MyStoreEmployee;
use \App\Lib\Moysklad\Receive\MyStoreProducts;
use App\Lib\Moysklad\Receive\MyStoreReceiveInterface;
use App\Models\Employee;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
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
        $this->runMyStoreRowsReceivedEvent(new MyStoreProducts(), new Products());
    }

    public function runMyStoreRowsReceivedEvent(MyStoreReceiveInterface $myStoreReceive, Model $model): void
    {
        $rows = $myStoreReceive->getRows();

        while($rows)
        {
            $page = $myStoreReceive->currentPage();

            // Pause every 40 request
            if($page > 0 && $page % 40 === 0)
                Sleep::for(1)->seconds();

            MyStoreRowsReceived::dispatch($rows, get_class($model));

            if($myStoreReceive->nextPage()){
                $rows = $myStoreReceive->getRows();
            }else
                $rows = null;
        }
    }
}
