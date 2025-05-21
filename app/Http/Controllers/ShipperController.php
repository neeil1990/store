<?php

namespace App\Http\Controllers;

use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperRequestDTO;
use App\Models\Shipper;
use App\Models\Store;
use App\Models\User;
use App\Presenters\ShipperDataTablePresenter;
use App\Services\ShipperService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipperController extends Controller
{
    public function index(): View
    {
        return view('shippers.index', [
            'minSumView' => view('shippers.cards.form-min-sum')->render(),
            'fillStorageView' => view('shippers.cards.form-fill-storage')->render(),
        ]);
    }

    public function json(Request $request, ShipperService $service): string
    {
        $sdt = ShipperDataTableDTO::fromRequest($request);

        $dto = $service->getAvailableWithProducts($sdt);

        return ShipperDataTablePresenter::present($dto);
    }

    public function edit($id, ShipperService $service): View
    {
        $shipper = $service->getShipperById($id);

        $users = User::all();

        $storages = Store::all();

        return view('shippers.edit', compact('shipper', 'users', 'storages', 'id'));
    }

    public function update(Request $request, int $id, ShipperService $service): RedirectResponse
    {
        $shipperRequestDTO = ShipperRequestDTO::makeFromRequest($request, $id);

        $shipper = $service->update($shipperRequestDTO);

        return redirect()->route('shipper.index');
    }

    public function minSumUpdate(Request $request): RedirectResponse
    {
        Shipper::query()->update(['min_sum' => $request->input('min_sum', 0)]);

        return redirect()->route('shipper.index');
    }

    public function fillStorageUpdate(Request $request): RedirectResponse
    {
        Shipper::query()->update(['fill_storage' => $request->input('fill_storage', 0)]);

        return redirect()->route('shipper.index');
    }
}
