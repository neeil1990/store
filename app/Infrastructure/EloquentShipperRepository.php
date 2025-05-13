<?php


namespace App\Infrastructure;

use App\Domain\Shipper\Shipper;
use App\Domain\Shipper\ShipperFactory;
use App\Domain\Shipper\ShipperRepository;
use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperPaginationDTO;
use App\DTO\ShipperRequestDTO;
use App\Models\Supplier;
use App\Models\Products;
use Illuminate\Database\Query\JoinClause;

class EloquentShipperRepository implements ShipperRepository
{
    public function getAvailableShippers(ShipperDataTableDTO $sdt): ShipperPaginationDTO
    {
        $page = $this->getCurrentNumberPage($sdt->start, $sdt->length);

        $order = $this->getColumnByIndex($sdt->columns, $sdt->orderBy);

        $availableShippers = Products::select('supplier')
            ->whereNotNull('supplier')
            ->whereJsonContains('attributes', Shipper::isAvailableShipper())
            ->groupBy('supplier');

        $items = Supplier::joinSub($availableShippers, 'available_supplier', function (JoinClause $join) {
            $join->on('suppliers.uuid', '=', 'available_supplier.supplier');
        })->with('shipper')
            ->orderBy($order, $sdt->dir)
            ->paginate($sdt->length, ['*'], 'page', $page);

        $factory = new ShipperFactory;

        $shippers = $items->map(function ($item) use ($factory) {
            return $factory->makeShipper($item);
        })->all();

        return new ShipperPaginationDTO($shippers, $items->total(), $items->total());
    }

    public function getShipperById(int $id): Shipper
    {
        $supplier = Supplier::with('shipper')->find($id);

        return (new ShipperFactory)->makeShipper($supplier);
    }

    public function updateShipper(ShipperRequestDTO $shipperRequestDTO): Shipper
    {
        $supplier = Supplier::with('shipper')->find($shipperRequestDTO->id);

        if ($supplier) {

            $shipper = $supplier->shipper()->updateOrCreate(['supplier_id' => $shipperRequestDTO->id], [
                'name' => $shipperRequestDTO->name,
                'email' => $shipperRequestDTO->email,
                'plan_fix_email' => $shipperRequestDTO->plan_fix_email,
                'plan_fix_link' => $shipperRequestDTO->plan_fix_link,
                'comment' => $shipperRequestDTO->comment,
                'min_sum' => $shipperRequestDTO->min_sum,
                'fill_storage' => $shipperRequestDTO->fill_storage
            ]);

            $shipper->users()->sync($shipperRequestDTO->users);

            $shipper->stores()->sync($shipperRequestDTO->storages);

            $supplier->refresh();
        }

        return (new ShipperFactory)->makeShipper($supplier);
    }

    private function getCurrentNumberPage(int $offset, int $length): int
    {
        return ($offset / $length) + 1;
    }

    private function getColumnByIndex(array $columns, int $id): ?string
    {
        return $columns[$id]['data'] ?? 'id';
    }
}
