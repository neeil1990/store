<?php


namespace App\Lib\Sale;

use App\Lib\Moysklad\Receive\MyStoreEmployee;
use \App\Lib\Moysklad\Receive\MyStoreProducts;
use App\Lib\Moysklad\Receive\MyStoreSupplier;
use App\Models\Employee;

class SyncMyStoreWithDataBase
{
    public function syncAll()
    {
        $this->productSync();
        $this->employeeSync();
        $this->supplierSync();
    }

    public function employeeSync()
    {
        $employee = (new MyStoreEmployee())->getRows();

        (new StoreEmployeeToDataBase(new Employee()))
            ->updateOrCreate($employee);
    }

    public function productSync()
    {
        (new MyStoreProducts())->event();
    }

    public function supplierSync()
    {
        (new MyStoreSupplier())->event();
    }
}
