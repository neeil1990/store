<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingStoreRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = new Setting();

        $token = $settings->token();

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
