<?php

namespace App\Actions;

use App\Domain\Shipper\ShipperFacade;
use App\Domain\Shipper\ShipperRepository;
use App\Models\Shipper;

class UpdateQuantityProductsAction
{
    private ShipperRepository $shipperRepository;

    protected int $count = 0;

    public function __construct(ShipperRepository $shipperRepository)
    {
        $this->shipperRepository = $shipperRepository;
    }

    public function execute(): void
    {
        $supplier_ids = Shipper::pluck('supplier_id')->toArray();

        foreach ($supplier_ids as $supplier_id) {

            $shipper = (new ShipperFacade($this->shipperRepository->getShipperById($supplier_id)))->getShipperWithProducts();

            if ($this->update($shipper->getShipperId(), $shipper->quantity())) {
                $this->count++;
            }
        }
    }

    public function getCount(): int
    {
        return $this->count;
    }

    private function update(int $id, int $value): bool
    {
        return Shipper::query()->where('id', $id)->update(['calc_quantity' => $value]);
    }
}
