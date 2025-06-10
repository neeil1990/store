<?php


namespace App\Services;


use App\Domain\Product\ProductRepository;
use App\Domain\Shipper\Shipper;
use App\Domain\Shipper\ShipperFacade;
use App\Domain\Shipper\ShipperRepository;
use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperRequestDTO;
use App\DTO\ShipperPaginationDTO;

class ShipperService
{
    private ProductRepository $productRepository;
    private ShipperRepository $shipperRepository;

    public function __construct(ShipperRepository $shipperRepository, ProductRepository $productRepository)
    {
        $this->shipperRepository = $shipperRepository;
        $this->productRepository = $productRepository;
    }

    public function getAvailableWithProducts(ShipperDataTableDTO $sdt): ShipperPaginationDTO
    {
        $dto = $this->shipperRepository->getAvailableShippers($sdt);

        /** @var Shipper $shipper */
        foreach ($dto->shippers as $shipper) {

            $shipperFacade = new ShipperFacade($shipper);

            $shipperFacade->setUsersToShipper();

            $shipperFacade->setProductsToShipper();

            $shipperFacade->setStoragesToShipper();

            $shipperFacade->setFilterToShipper();
        }

        return $dto;
    }

    public function getShipperById(int $id): Shipper
    {
        $shipper = new ShipperFacade($this->shipperRepository->getShipperById($id));

        return $shipper->getShipperWithWarehousesAndUsers();
    }

    public function update(ShipperRequestDTO $shipperRequestDTO): Shipper
    {
        return $this->shipperRepository->updateShipper($shipperRequestDTO);
    }

}
