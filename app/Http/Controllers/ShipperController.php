<?php

namespace App\Http\Controllers;

use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperRequestDTO;
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
        return view('shippers.index');
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

        return view('shippers.edit', compact('shipper', 'users', 'id'));
    }

    public function update(Request $request, int $id, ShipperService $service): RedirectResponse
    {
        $shipperRequestDTO = ShipperRequestDTO::makeFromRequest($request, $id);

        $shipper = $service->update($shipperRequestDTO);

        return redirect()->route('shipper.index');
    }
}
