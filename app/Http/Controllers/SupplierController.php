<?php

namespace App\Http\Controllers;

use App\DataTables\SuppliersDataTable;
use App\Exports\BuyersExport;
use App\Exports\SuppliersExport;
use App\Models\Products;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SupplierController extends Controller
{
    const SUPPLIER_INDEX = 2;

    protected $excelFileName = null;

    public function index()
    {
        $store = Store::all();
        $filters = Auth::user()->filters;

        return view('suppliers.index', compact('store', 'filters'));
    }

    public function json()
    {
        $model = new Products();

        $export = request('exports');
        $stores = request('stores', []);

        $dataTable = new SuppliersDataTable($model->suppliersDataTable($stores)->whereMinBalanceNotNull());

        if ($export == 'suppliers') {
            return $this->exportForSuppliers($dataTable->getCollection());
        } else if ($export == 'buyers') {
            return $this->exportForBuyers($dataTable->getCollection());
        }

        return $dataTable->getJson();
    }

    private function exportForSuppliers(Collection $collection)
    {
        $columns = request('columns');

        $export = new SuppliersExport($collection);

        if ($columns[self::SUPPLIER_INDEX]['search']['value']) {
            $export->setFileName($collection->value('suppliers.name') . '-' . Carbon::now() . SuppliersExport::EXE);
        }

        return $export->download();
    }

    private function exportForBuyers(Collection $collection)
    {
        $export = new BuyersExport($collection);

        return $export->download();
    }
}
