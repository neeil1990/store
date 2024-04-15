<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingStoreRequest;
use App\Lib\Moysklad\StoreToken;
use App\Models\Setting;
use Illuminate\Http\Request;

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
}
