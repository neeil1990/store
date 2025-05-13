<?php


namespace App\Domain\Shipper;


use App\Models\Supplier;

class ShipperFactory
{
    public function makeShipper(Supplier $supplier)
    {
        $sm = $supplier->shipper;

        $shipper = new Shipper(
            $sm->id ?? null,
            $supplier->id ?? null,
            $supplier->uuid ?? null,
            $supplier->name ?? null,
            $sm ? $sm->name : null,
            $sm ? $sm->email : null,
            $sm ? $sm->plan_fix_email : null,
            $sm ? $sm->plan_fix_link : null,
            $sm ? $sm->comment : null,
            $sm ? $sm->min_sum : 0,
            $sm ? $sm->fill_storage : 0
        );

        $shipper->addStorages($sm ? $sm->stores->all() : []);

        return $shipper;
    }
}
