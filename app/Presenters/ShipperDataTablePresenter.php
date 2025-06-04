<?php


namespace App\Presenters;


use App\Domain\Shipper\Shipper;
use App\DTO\ShipperPaginationDTO;
use Illuminate\Support\Arr;


class ShipperDataTablePresenter extends ShipperPresenter
{
    protected Shipper $shipper;
    protected int $minBalance;

    public function data(Shipper $shipper): array
    {
        $this->shipper = $shipper;
        $this->minBalance = $shipper->totalMinBalanceProducts();

        return [
            'id' => $shipper->getSupplierId(),
            'name' => $this->nameView(),
            'employee' => $this->employeeView(),
            'filter' => $this->filterView(),
            'min_sum' => $this->minSumView(),
            'fill_storage' => $shipper->fill_storage,
            'fill' => $this->fillView(),
            'fillByStorage' => $this->fillByStorageView(),
            'quantity' => $shipper->quantity(),
            'to_buy' => amount($shipper->totalToBuy()),
            'total_cost' => money($shipper->buyPrice()),
            'sender' => '',
            'text_for_sender' => '',
            'export' => $this->exportView(),
            'stat' => '',
            'edit' => $this->editView(),
        ];
    }

    public function present(ShipperPaginationDTO $dto): string
    {
        $collect = collect([
            'draw' => request('draw'),
            'recordsTotal' => $dto->total,
            'recordsFiltered' => $dto->total,
            'data' => array_map([$this, 'data'], $dto->shippers),
            'error' => '',
        ]);

        return $collect->toJson();
    }

    protected function nameView(): string
    {
        $shipper = $this->shipper;

        $name = $shipper->getName();
        $old_name = $shipper->getOldName();

        return view('shippers.columns.name', compact('name', 'old_name'))->render();
    }

    protected function employeeView(): string
    {
        $shipper = $this->shipper;

        $users = $shipper->getUsers();

        return view('shippers.columns.users', compact('users'))->render();
    }

    protected function filterView(): string
    {
        $shipper = $this->shipper;

        $filter = $shipper->filter();

        return view('shippers.columns.filter', compact('filter'))->render();
    }

    protected function minSumView(): string
    {
        $shipper = $this->shipper;

        return money($shipper->getMinSum());
    }

    protected function fillView(): string
    {
        $shipper = $this->shipper;

        $totalStock = $shipper->totalStockProducts();

        $minBalance = $this->minBalance;

        $fillValue = $shipper->getFillStorage();

        return view('shippers.columns.fill', compact('totalStock', 'minBalance', 'fillValue'))->render();
    }

    protected function fillByStorageView(): string
    {
        $shipper = $this->shipper;

        $minBalance = $this->minBalance;

        $storages = $shipper->getStockByStorages();

        $sumStock = array_sum(Arr::pluck($storages, 'quantity'));

        $fillByStorageValue = $shipper->getFillStorageByStorages();

        return view('shippers.columns.fillByStorage', compact('minBalance', 'storages', 'sumStock', 'fillByStorageValue'))->render();
    }

    protected function exportView(): string
    {
        $shipper = $this->shipper;

        $exportSuppliers = $shipper->generateSuppliersExportLink();
        $exportBuyers = $shipper->generateBuyersExportLink();

        return view('shippers.columns.export', ['suppliers' => $exportSuppliers, 'buyers' => $exportBuyers])->render();
    }

    protected function editView(): string
    {
        $shipper = $this->shipper;

        return view('shippers.columns.edit', ['link' => route('shipper.edit', $shipper->getSupplierId())])->render();
    }
}
