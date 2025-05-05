<?php


namespace App\Services;


use App\Domain\Product\ProductRepository;
use App\Domain\Shipper\Shipper;
use App\Domain\Shipper\ShipperRepository;
use App\Domain\User\UserRepository;
use App\DTO\ShipperDataTableDTO;
use App\DTO\ShipperRequestDTO;
use App\DTO\ShipperPaginationDTO;

class ShipperService
{
    private ProductRepository $productRepository;
    private ShipperRepository $shipperRepository;
    private UserRepository $userRepository;

    public function __construct(ShipperRepository $shipperRepository, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->shipperRepository = $shipperRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function getAvailableWithProducts(ShipperDataTableDTO $sdt): ShipperPaginationDTO
    {
        $dto = $this->shipperRepository->getAvailableShippers($sdt);

        $this->attachProductsToShippers($dto->shippers);

        $this->addUsersToShippers($dto->shippers);

        return $dto;
    }

    public function getShipperById(int $id): Shipper
    {
        $shipper = $this->shipperRepository->getShipperById($id);

        $shipper->addUsers($this->userRepository->getUsersBy($shipper));

        return $shipper;
    }

    public function update(ShipperRequestDTO $shipperRequestDTO): Shipper
    {
        return $this->shipperRepository->updateShipper($shipperRequestDTO);
    }

    private function attachProductsToShippers(array $shippers): void
    {
        foreach ($shippers as $shipper) {
            $products = $this->productRepository->getAvailableProductsToShipper($shipper);

            /** @var Shipper $shipper */
            $shipper->setProducts($products);
        }
    }

    private function addUsersToShippers(array $shippers): void
    {
        foreach ($shippers as $shipper) {
            $shipper->addUsers($this->userRepository->getUsersBy($shipper));
        }
    }

}
