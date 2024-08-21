<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FiltersController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return $user->filters()->where('active', $request->input('active'))->value('payload');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $user->filters()->create([
            'name' => $request->input('name'),
            'payload' => $request->input('params'),
        ]);

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();

        $user->filters()->update(['active' => false]);

        if ($id > 0) {
            $user->filters()->where('id', $id)->update(['active' => true]);
        }
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        $user->filters()->where('id', $id)->delete();
    }
}
