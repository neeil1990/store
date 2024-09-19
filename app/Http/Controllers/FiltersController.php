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
        $name = $request->input('name');
        $params = $request->input('params');
        $id = $request->input('id');

        if ($id > 0) {

            $update = ['payload' => $params];

            if ($name) {
                $update['name'] = $name;
            }

            $user->filters()->where('id', $id)
                ->update($update);

        } else if ($name) {

            $user->filters()->create([
                'name' => $name,
                'payload' => $params,
            ]);

        }

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
