<?php


namespace App\Lib\Sale;

use App\Lib\Moysklad\Receive\MyStoreEmployee;
use App\Lib\Moysklad\Receive\MyStoreGroup;
use App\Lib\Moysklad\Receive\MyStoreProductFolder;
use \App\Lib\Moysklad\Receive\MyStoreProducts;
use App\Lib\Moysklad\Receive\MyStoreSupplier;
use App\Lib\Sale\Store\StoreGroupToDataBase;
use App\Lib\Sale\Store\StoreEmployeeToDataBase;
use App\Models\Employee;
use App\Models\Group;

class SyncMyStoreWithDataBase
{
    public function syncAll()
    {
        $this->productSync();
        $this->employeeSync();
        $this->supplierSync();
        $this->groupSync();
        $this->productFolderSync();
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

    public function productFolderSync()
    {
        (new MyStoreProductFolder())->event();
    }

    public function groupSync()
    {
        $group = (new MyStoreGroup())->getRows();

        (new StoreGroupToDataBase(new Group()))
            ->updateOrCreate($group);
    }
}
