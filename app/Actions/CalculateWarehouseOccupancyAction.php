<?php

namespace App\Actions;

use App\Domain\Shipper\Shipper as ShipperEntity;
use App\Domain\Shipper\ShipperRepository;
use App\Domain\Shipper\ShipperFacade;
use App\Models\Shipper;

class CalculateWarehouseOccupancyAction
{
    private ShipperRepository $shipperRepository;

    protected int $updated = 0;

    public function __construct(ShipperRepository $shipperRepository)
    {
        $this->shipperRepository = $shipperRepository;
    }

    public function execute(): int
    {
        $suppliers = Shipper::pluck('supplier_id');

        foreach ($suppliers as $supplier_id) {
            $shipper = $this->shipperRepository->getShipperById($supplier_id);

            $data = $this->calculateWarehouseOccupancyPercent($shipper);

            if ($this->saveWarehouseOccupancyPercent($shipper->getShipperId(), $data)) {
                $this->updated++;
            }
        }

        return $this->updated;
    }

    protected function calculateWarehouseOccupancyPercent(ShipperEntity $shipper): array
    {
        $shipperFacade = new ShipperFacade($shipper);

        $shipperFacade->setProductsToShipper();

        $occupancyPercentAll = $shipper->getWarehouseOccupancyPercentAll();

        $shipperFacade->setStoragesToShipper();

        $occupancyPercentSelected = $shipper->getWarehouseOccupancyPercentSelected();

        return [
            'calc_occupancy_percent_all' => $occupancyPercentAll,
            'calc_occupancy_percent_selected' => $occupancyPercentSelected,
        ];
    }

    protected function saveWarehouseOccupancyPercent(int $id, array $data): bool
    {
        return Shipper::where('id', $id)->update($data);
    }

}
