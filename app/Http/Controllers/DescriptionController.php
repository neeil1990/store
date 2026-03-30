<?php

namespace App\Http\Controllers;

use App\Http\Requests\DescriptionRequest;
use App\Models\Description;
use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    public function index()
    {
        $items = Description::orderBy('key')->paginate(20);
        return view('descriptions.index', compact('items'));
    }

    public function create()
    {
        $description = new Description();
        return view('descriptions.create', compact('description'));
    }

    public function store(DescriptionRequest $request)
    {
        $data = $request->validated();
        $description = Description::create($data);
        Description::forgetCache($description->key);

        return redirect()->route('descriptions.index')->with('success', 'Description created.');
    }

    public function show(Description $description)
    {
        return view('descriptions.show', compact('description'));
    }

    public function edit(Description $description)
    {
        return view('descriptions.edit', compact('description'));
    }

    public function update(DescriptionRequest $request, Description $description)
    {
        $oldKey = $description->key;
        $data = $request->validated();
        $description->update($data);

        // Если ключ изменился, очистим старый и новый
        if ($oldKey !== $description->key) {
            Description::forgetCache($oldKey);
        }
        Description::forgetCache($description->key);

        return redirect()->route('descriptions.index')->with('success', 'Description updated.');
    }

    public function destroy(Description $description)
    {
        $key = $description->key;
        $description->delete();
        Description::forgetCache($key);

        return redirect()->route('descriptions.index')->with('success', 'Description deleted.');
    }

    // Дополнительный метод для получения по ключу (json/plain)
    public function showByKey($key)
    {
        $value = Description::getByKey($key, null);
        if (request()->wantsJson()) {
            return response()->json(['key' => $key, 'content' => $value]);
        }

        return view('descriptions.showByKey', compact('key', 'value'));
    }

    // Возвращает чистый JSON по ключу всегда
    public function jsonByKey($key)
    {
        $value = Description::getByKey($key, null);
        return response()->json([ 'key' => $key, 'content' => $value ]);
    }
}
