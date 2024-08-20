<?php

namespace App\Http\Controllers;

use App\DataTables\SuppliersDataTable;
use App\Exports\SuppliersExport;
use App\Models\Products;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;


class SupplierController extends Controller
{
    const SUPPLIER_INDEX = 2;

    protected $excelFileName = null;

    public function index()
    {
        $store = Store::all();

        return view('suppliers.index', compact('store'));
    }

    public function json()
    {
        $model = new Products();

        $export = request('exports', []);
        $stores = request('stores', []);

        $dataTable = new SuppliersDataTable($model->suppliersDataTable($stores));

        if ($export) {
            return $this->export($dataTable->getCollection());
        }

        return $dataTable->getJson();
    }

    private function export(Collection $collection)
    {
        $columns = request('columns');

        $export = new SuppliersExport($collection);

        if ($columns[self::SUPPLIER_INDEX]['search']['value']) {
            $export->setFileName($collection->value('suppliers.name') . '-' . Carbon::now() . SuppliersExport::EXE);
        }

        return $export->download();
    }
}
