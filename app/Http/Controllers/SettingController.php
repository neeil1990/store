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
        $siteTitle = Setting::where('key', 'site_title')->value('value');
        $siteName = Setting::where('key', 'site_name')->value('value');
        $footerPhone = Setting::where('key', 'footer_phone')->value('value');
        $footerTelegram = Setting::where('key', 'footer_telegram')->value('value');
        $showFooterPhone = Setting::where('key', 'show_footer_phone')->value('value') !== '0';
        $showFooterTelegram = Setting::where('key', 'show_footer_telegram')->value('value') !== '0';

        return view('setting.index', compact('token', 'warehouseItemParam', 'measureItemParam', 'siteTitle', 'siteName', 'footerPhone', 'footerTelegram', 'showFooterPhone', 'showFooterTelegram'));
    }

    public function store(SettingStoreRequest $request)
    {
        $valid = $request->validated();

        $status = 'setting-store';

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

    public function storeAll(Request $request)
    {
        $data = $request->only([
            'site_title',
            'site_name',
            'token',
            'warehouse_item_param',
            'measure_item_param',
            'footer_phone',
            'footer_telegram',
        ]);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Setting::updateOrCreate(['key' => 'show_footer_phone'], ['value' => $request->has('show_footer_phone') ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'show_footer_telegram'], ['value' => $request->has('show_footer_telegram') ? '1' : '0']);
        return redirect()->route('setting.index')->with('status', 'setting-store-all');
    }
}
