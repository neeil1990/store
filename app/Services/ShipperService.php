<?php


namespace App\Services;


use App\Domain\Product\ProductRepository;
use App\Domain\Shipper\Shipper;
use App\Domain\Shipper\ShipperRepository;
use App\Domain\User\UserRepository;
use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperRequestDTO;

class ShipperService
{
    private $productRepository;
    private $shipperRepository;
    private $userRepository;

    public function __construct(ShipperRepository $shipperRepository, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->shipperRepository = $shipperRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function getAvailableWithProducts(ShipperDataTableDTO $sdt)
    {
        $dto = $this->shipperRepository->getAvailableShippers($sdt);

        $this->attachProductsToShippers($dto->shippers);

        $this->addUsersToShippers($dto->shippers);

        return $dto;
    }

    public function getShipperById(int $id): Shipper
    {
        $shipper = $this->shipperRepository->getShipperById($id);

        $this->attachUsersToShipper($shipper);

        return $shipper;
    }

    public function update(ShipperRequestDTO $shipperRequestDTO): Shipper
    {
        return $this->shipperRepository->updateShipper($shipperRequestDTO);
    }

    private function attachProductsToShippers(array $shippers)
    {
        foreach ($shippers as $shipper) {
            /** @var Shipper $shipper */
            $shipper->setProducts($this->productRepository->getAvailableProductsToShipper($shipper));
        }
    }

    private function attachUsersToShipper(Shipper $shipper)
    {
        $shipper->addUsers($this->userRepository->getUsersBy($shipper));
    }

    private function addUsersToShippers(array $shippers): void
    {
        foreach ($shippers as $shipper) {
            $this->attachUsersToShipper($shipper);
        }
    }

}
