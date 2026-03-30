<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingStoreRequest;
use App\Imports\MinimumBalanceImport;
use App\Lib\Moysklad\StoreToken;
use App\Models\Setting;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SettingController extends Controller
{
    public function index()
    {
        $token = (new StoreToken())->getToken();
        $warehouseItemParam = Setting::where('key', 'warehouse_item_param')->value('value');
        $measureItemParam = Setting::where('key', 'measure_item_param')->value('value');

        return view('setting.index', compact('token', 'warehouseItemParam', 'measureItemParam'));
    }

    public function store(SettingStoreRequest $request)
    {
        $valid = $request->validated();

        $status = 'setting-store';

        if ($valid['key'] === 'warehouse_item_param') {
            $status = 'setting-warehouse-item-param';
        } elseif ($valid['key'] === 'measure_item_param') {
            $status = 'setting-measure-item-param';
        }

        Setting::updateOrCreate(
            ['key' => $valid['key']],
            ['value' => $valid['value']]
        );

        return redirect()->route('setting.index')->with('status', $status);
    }

    public function import(Request $request)
    {
        Excel::import(new MinimumBalanceImport, $request->file('excel'));

        return redirect()->route('setting.index')->with('status', 'setting-import');
    }
}
