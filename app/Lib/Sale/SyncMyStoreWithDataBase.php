<?php


namespace App\Lib\Sale;

use App\Lib\Moysklad\Receive\MyStoreAttributes;
use App\Lib\Moysklad\Receive\MyStoreCountry;
use App\Lib\Moysklad\Receive\MyStoreEmployee;
use App\Lib\Moysklad\Receive\MyStoreGroup;
use App\Lib\Moysklad\Receive\MyStoreProductFolder;
use \App\Lib\Moysklad\Receive\MyStoreProducts;
use App\Lib\Moysklad\Receive\MyStoreSupplier;
use App\Lib\Moysklad\Receive\MyStoreUom;
use App\Lib\Sale\Store\StoreAttributesToDataBase;
use App\Lib\Sale\Store\StoreCountryToDataBase;
use App\Lib\Sale\Store\StoreGroupToDataBase;
use App\Lib\Sale\Store\StoreEmployeeToDataBase;
use App\Lib\Sale\Store\StoreUomToDataBase;
use App\Models\Attribute;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Uom;

class SyncMyStoreWithDataBase
{
    public function syncAll()
    {
        $this->productSync();
        $this->employeeSync();
        $this->supplierSync();
        $this->groupSync();
        $this->productFolderSync();
        $this->uomSync();
        $this->countrySync();
        $this->attributeSync();
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

    public function uomSync()
    {
        $uom = (new MyStoreUom())->getRows();

        (new StoreUomToDataBase(new Uom()))->updateOrCreate($uom);
    }

    public function countrySync()
    {
        $country = (new MyStoreCountry())->getRows();

        (new StoreCountryToDataBase(new Country()))->updateOrCreate($country);
    }

    public function attributeSync()
    {
        $attribute = (new MyStoreAttributes())->getRows();

        (new StoreAttributesToDataBase(new Attribute()))->updateOrCreate($attribute);
    }
}
