<?php


namespace App\Domain\User;


use App\Domain\Shipper\Shipper;

interface UserRepository
{
    public function getUsersBy(Shipper $shipper): array;
}
