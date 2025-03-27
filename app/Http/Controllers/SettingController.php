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

        return view('setting.index', compact('token'));
    }

    public function store(SettingStoreRequest $request)
    {
        $valid = $request->validated();

        Setting::updateOrCreate(
            ['key' => $valid['key']],
            ['value' => $valid['value']]
        );

        return redirect()->route('setting.index')->with('status', 'setting-store');
    }

    public function import(Request $request)
    {
        Excel::import(new MinimumBalanceImport, $request->file('excel'));

        return redirect()->route('setting.index')->with('status', 'setting-import');
    }
}
