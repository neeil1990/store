<?php


namespace App\Presenters;

use App\DTO\ShipperPaginationDTO;

abstract class ShipperPresenter
{
    abstract public static function present(ShipperPaginationDTO $dto);
}
