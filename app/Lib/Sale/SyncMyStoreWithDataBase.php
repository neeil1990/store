<?php


namespace App\Lib\Sale;

use App\Lib\Moysklad\Receive\MyStoreAttributes;
use App\Lib\Moysklad\Receive\MyStoreBundle;
use App\Lib\Moysklad\Receive\MyStoreCountry;
use App\Lib\Moysklad\Receive\MyStoreEmployee;
use App\Lib\Moysklad\Receive\MyStoreGroup;
use App\Lib\Moysklad\Receive\MyStoreProductFolder;
use \App\Lib\Moysklad\Receive\MyStoreProducts;
use App\Lib\Moysklad\Receive\MyStoreReserve;
use App\Lib\Moysklad\Receive\MyStoreStock;
use App\Lib\Moysklad\Receive\MyStoreStockTotal;
use App\Lib\Moysklad\Receive\MyStoreStore;
use App\Lib\Moysklad\Receive\MyStoreSupplier;
use App\Lib\Moysklad\Receive\MyStoreTransit;
use App\Lib\Moysklad\Receive\MyStoreUom;
use App\Lib\Sale\Store\StoreAttributesToDataBase;
use App\Lib\Sale\Store\StoreCountryToDataBase;
use App\Lib\Sale\Store\StoreGroupToDataBase;
use App\Lib\Sale\Store\StoreEmployeeToDataBase;
use App\Lib\Sale\Store\StoreReserveToDataBase;
use App\Lib\Sale\Store\StoreStockToDataBase;
use App\Lib\Sale\Store\StoreStoreToDataBase;
use App\Lib\Sale\Store\StoreTransitToDataBase;
use App\Lib\Sale\Store\StoreUomToDataBase;
use App\Models\Attribute;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Reserve;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Transit;
use App\Models\Uom;
use App\Models\StockTotal;

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
        $this->stockSync();
        $this->reserveSync();
        $this->transitSync();
        $this->storeSync();
        $this->bundleSync();
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

    public function stockSync()
    {
        $model = new Stock();

        $model->truncate();

        $stocks = (new MyStoreStock())->getRows();
        (new StoreStockToDataBase($model))->create($stocks);

        foreach ((new MyStoreStockTotal())->getRows() as $item) {
            if ($item['stock'] === 0) {
                (new StockTotal())->create($item);
            }
        }
    }

    public function reserveSync()
    {
        $model = new Reserve();

        $model->truncate();

        $reserve = (new MyStoreReserve())->getRows();
        (new StoreReserveToDataBase($model))->create($reserve);
    }

    public function transitSync()
    {
        $model = new Transit();

        $model->truncate();

        $transit = (new MyStoreTransit())->getRows();
        (new StoreTransitToDataBase($model))->create($transit);
    }

    public function storeSync()
    {
        $store = (new MyStoreStore())->getRows();
        (new StoreStoreToDataBase(new Store()))->updateOrCreate($store);
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

    public function bundleSync()
    {
        (new MyStoreBundle())->event();
    }
}
