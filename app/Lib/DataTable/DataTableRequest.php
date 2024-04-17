<?php


namespace App\Lib\DataTable;


use App\Lib\DataTable\Interfaces\DataTableInterface;

abstract class DataTableRequest implements DataTableInterface
{
    protected $request;

    protected $columns;
    protected $order;
    protected $start;
    protected $length;
    protected $search;

    protected $data = [];
    protected $recordsTotal = 0;
    protected $recordsFiltered = 0;

    public function setRequest(array $request): void
    {
        $this->request = $request;

        foreach ($request as $key => $val)
            if(property_exists($this, $key))
                $this->$key = $val;
    }

    public function recordsTotal(): int
    {
        return $this->recordsTotal;
    }

    public function recordsFiltered(): int
    {
        return $this->recordsFiltered;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function error(): string
    {
        return '';
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setRecordsTotal(int $recordsTotal): void
    {
        $this->recordsTotal = $recordsTotal;
    }

    public function setRecordsFiltered(int $recordsFiltered): void
    {
        $this->recordsFiltered = $recordsFiltered;
    }


}
