<?php


namespace App\Presenters;


use App\Domain\Shipper\Shipper;
use App\DTO\ShipperPaginationDTO;
use Illuminate\Support\Arr;



class ShipperDataTablePresenter extends ShipperPresenter
{
    public static function data(Shipper $shipper): array
    {
        $minBalance = $shipper->totalMinBalanceProducts();

        $storages = $shipper->getStockByStorages();
        $sumStock = array_sum(Arr::pluck($storages, 'quantity'));

        $fillByStorageValue = self::fillCalc($sumStock, $minBalance);

        $totalStock = $shipper->totalStockProducts();
        $fillValue = self::fillCalc($totalStock, $minBalance);

        $filter = $shipper->filter();

        $exportSuppliers = $shipper->generateSuppliersExportLink();
        $exportBuyers = $shipper->generateBuyersExportLink();

        return [
            'id' => $shipper->supplier_id,
            'name' => view('shippers.columns.name', ['origin_name' => $shipper->origin_name, 'name' => $shipper->name])->render(),
            'employee' => view('shippers.columns.users', ['users' => $shipper->users])->render(),
            'filter' => view('shippers.columns.filter', ['filter' => $filter])->render(),
            'min_sum' => money($shipper->min_sum),
            'fill_storage' => $shipper->fill_storage,
            'fill' => view('shippers.columns.fill', compact('totalStock', 'minBalance', 'fillValue'))->render(),
            'fillByStorage' => view('shippers.columns.fillByStorage', compact('minBalance', 'storages', 'sumStock', 'fillByStorageValue'))->render(),
            'quantity' => $shipper->quantity(),
            'to_buy' => amount($shipper->totalToBuy()),
            'total_cost' => money($shipper->buyPrice()),
            'sender' => '',
            'text_for_sender' => '',
            'export' => view('shippers.columns.export', ['suppliers' => $exportSuppliers, 'buyers' => $exportBuyers])->render(),
            'stat' => '',
            'edit' => view('shippers.columns.edit', ['link' => route('shipper.edit', $shipper->supplier_id)])->render(),
        ];
    }

    public static function present(ShipperPaginationDTO $dto): string
    {
        $collect = collect([
            'draw' => request('draw'),
            'recordsTotal' => $dto->total,
            'recordsFiltered' => $dto->total,
            'data' => array_map([self::class, 'data'], $dto->shippers),
            'error' => '',
        ]);

        return $collect->toJson();
    }

    public static function fillCalc($totalStock, $minBalance): int
    {
        if ($minBalance > 0) {
            return round(($totalStock / $minBalance) * 100);
        }

        return 0;
    }
}
