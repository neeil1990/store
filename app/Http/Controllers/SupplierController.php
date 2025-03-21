<?php

namespace App\Http\Controllers;

use App\DataTables\SuppliersDataTable;
use App\Exports\BuyersExport;
use App\Exports\ExportInterface;
use App\Exports\SuppliersExport;
use App\Models\Products;
use App\Models\Store;
use Carbon\Carbon;
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
            return $this->export(new SuppliersExport($dataTable->getCollection()));
        } else if ($export == 'buyers') {
            return $this->export(new BuyersExport($dataTable->getCollection()));
        }

        return $dataTable->getJson();
    }

    private function export(ExportInterface $export)
    {
        if ($this->hasSearchableValue(self::SUPPLIER_INDEX)) {
            $name = $export->getCollection()->value('suppliers.name');

            $export->setFileName(implode(' - ', [$name, Carbon::now() . SuppliersExport::EXE]));
        }

        return $export->download();
    }

    private function hasSearchableValue(int $idx): bool
    {
        $columns = request('columns');

        if ($columns[$idx]['search']['value']) {
            return true;
        }

        return false;
    }
}
