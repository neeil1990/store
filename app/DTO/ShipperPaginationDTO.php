<?php


namespace App\DTO;


class ShipperPaginationDTO
{
    public array $shippers = [];
    public int $count = 0;
    public int $total = 0;

    public function __construct(array $shippers, int $count, int $total)
    {
        $this->shippers = $shippers;
        $this->count = $count;
        $this->total = $total;
    }
}
