<?php


namespace App\Presenters;


use App\Domain\Shipper\Shipper;
use App\DTO\ShipperPaginationDTO;

class ShipperDataTablePresenter extends ShipperPresenter
{
    public static function data(Shipper $shipper): array
    {
        return [
            'id' => $shipper->supplier_id,
            'name' => view('shippers.columns.name', ['origin_name' => $shipper->origin_name, 'name' => $shipper->name])->render(),
            'employee' => view('shippers.columns.users', ['users' => $shipper->users])->render(),
            'filter' => '',
            'min_sum' => $shipper->min_sum,
            'fill_storage' => $shipper->fill_storage,
            'fill' => round(($shipper->isAvailableProducts() / $shipper->totalProducts()) * 100, 2),
            'quantity' => $shipper->quantity(),
            'to_buy' => $shipper->totalToBuy(),
            'total_cost' => round($shipper->totalToBuy() * $shipper->quantity() * $shipper->min_sum, 2),
            'sender' => '',
            'text_for_sender' => '',
            'export' => '',
            'stat' => '',
            'edit' => view('shippers.columns.edit', ['link' => route('shipper.edit', $shipper->supplier_id)])->render(),
        ];
    }

    public static function present(ShipperPaginationDTO $dto)
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
}
