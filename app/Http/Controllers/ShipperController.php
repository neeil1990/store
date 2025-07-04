<?php

namespace App\Http\Controllers;

use App\Actions\CalculateFieldsAction;
use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperRequestDTO;
use App\Infrastructure\EloquentShipperRepository;
use App\Models\Filter;
use App\Models\Shipper;
use App\Models\Store;
use App\Models\User;
use App\Presenters\ShipperDataTablePresenter;
use App\Services\ShipperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipperController extends Controller
{
    public function index(): View
    {
        $calculate = new CalculateFieldsAction();

        return view('shippers.index', ['computedAt' =>  $calculate->computedAt()]);
    }

    public function json(Request $request, ShipperService $service): string
    {
        $sdt = ShipperDataTableDTO::fromRequest($request);

        $shippers = $service->getAvailableWithProducts($sdt);

        return (new ShipperDataTablePresenter)->present($shippers);
    }

    public function edit($id, ShipperService $service): View
    {
        $shipper = $service->getShipperById($id);

        $users = User::all();

        $storages = Store::all();

        $filters = Filter::with('user')->get();

        return view('shippers.edit', compact('shipper', 'users', 'storages', 'id', 'filters'));
    }

    public function update(Request $request, int $id, ShipperService $service): RedirectResponse
    {
        $shipperRequestDTO = ShipperRequestDTO::makeFromRequest($request, $id);

        $shipper = $service->update($shipperRequestDTO);

        return redirect()->route('shipper.index');
    }

    public function bulkUpdate(Request $request, string $field): RedirectResponse
    {
        Shipper::query()->update([$field => $request->input($field, 0)]);

        return redirect()->route('shipper.index');
    }

    public function bulkUpdateWarehouse(Request $request): RedirectResponse
    {
        $warehouses = $request->input('warehouses', []);

        foreach (Shipper::all() as $shipper) {
            $shipper->stores()->sync($warehouses);
        }

        return redirect()->route('shipper.index');
    }


    public function calculateFields(): JsonResponse
    {
        $calculate = new CalculateFieldsAction();

        $calculate->execute();

        return response()->json([
            'message' => $calculate->getMessage(),
        ]);
    }

    public function warehouseStockAll(int $supplier_id): string
    {
        $repository = new EloquentShipperRepository;

        $shipper = $repository->getShipperById($supplier_id);

        $facade = new \App\Domain\Shipper\ShipperFacade($shipper);

        return view('shippers.partials.warehouse-occupancy-all-tooltip', [
            'stock' => $facade->getWarehouseStockAll(),
            'balance' => $facade->getMinimumBalance()
        ])->render();
    }

    public function warehouseStockSelected(int $supplier_id): string
    {
        $repository = new EloquentShipperRepository;

        $facade = new \App\Domain\Shipper\ShipperFacade($repository->getShipperById($supplier_id));

        $shipper = $facade->getShipperWithWarehouses();

        return view('shippers.partials.warehouse-occupancy-selected-tooltip', [
            'warehouses' => $shipper->getStockByStorages(),
            'balance' => $facade->getMinimumBalance(),
            'stock' => $facade->getWarehouseStockAll()
        ])->render();
    }
}
