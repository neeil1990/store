<?php


namespace App\Domain\Shipper;

use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperPaginationDTO;
use App\DTO\ShipperRequestDTO;

interface ShipperRepository
{
    public function getAvailableShippers(ShipperDataTableDTO $requestDTO): ShipperPaginationDTO;

    public function getShipperById(int $id): Shipper;

    public function updateShipper(ShipperRequestDTO $shipperRequestDTO): Shipper;
}
