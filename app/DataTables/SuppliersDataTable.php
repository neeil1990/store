<?php

namespace App\DataTables;

use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SuppliersDataTable
{
    protected $query;
    protected $dataTable;

    public function __construct(Builder $query)
    {
        $this->query = $query;

        $this->dataTable = DataTables::eloquent($this->query)->filter([$this, 'filter']);
    }

    public function filter($query): void
    {
        $search = request('search');

        if ($search['value']) {
            $query->where('products.name', 'like', "%" . $search['value'] . "%");
        }
    }

    public function getCollection(): Collection
    {
        return $this->dataTable->getFilteredQuery()->get();
    }

    public function get()
    {
        return $this->dataTable;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getJson()
    {
        return $this->get()->toJson();
    }

}
