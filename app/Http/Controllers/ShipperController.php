<?php

namespace App\Http\Controllers;

use App\Actions\UpdateOccupancyShipperAction;
use App\Actions\UpdateQuantityShipperAction;
use App\Actions\UpdateToPurchaseShipperAction;
use App\Domain\Shipper\ShipperFacade;
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
use App\Actions\CalculateWarehouseOccupancyAction;

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

    public function calculateFields(): JsonResponse
    {
        $message = __('Вычисляемые поля успешно обновлены! ') . PHP_EOL;

        $occupancyCount = new UpdateOccupancyShipperAction;
        $occupancyCount->execute();

        $message .= 'Процент наполняемости: ' . $occupancyCount->getCount() . PHP_EOL;

        $quantityUpdate = new UpdateQuantityShipperAction;
        $quantityUpdate->execute();

        $message .= ' Количество товаров: ' . $quantityUpdate->getCount() . PHP_EOL;

        $purchase = new UpdateToPurchaseShipperAction;
        $purchase->execute();

        $message .= ' К закупке: ' . $purchase->getCount() . PHP_EOL;

        return response()->json([
            'message' => nl2br($message),
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
