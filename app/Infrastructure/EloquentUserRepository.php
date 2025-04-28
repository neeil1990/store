<?php


namespace App\Infrastructure;


use App\Domain\Shipper\Shipper;
use App\Domain\User\User;
use App\Models\User as ModelUser;
use App\Models\Shipper as ModelShipper;
use App\Domain\User\UserRepository;

class EloquentUserRepository implements UserRepository
{

    public function getUsersBy(Shipper $shipper): array
    {
        $shipper = ModelShipper::with('users')->find($shipper->id);

        if (! $shipper) {
            return [];
        }

        return $shipper->users->map(function (ModelUser $user) {
            return new User($user->id, $user->name, $user->email);
        })->all();
    }
}
