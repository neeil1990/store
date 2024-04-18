<?php


namespace App\Lib\Sale;

use App\Lib\DataTable\DataTableRequest;
use \App\Models\Products;

class ProductsTable extends DataTableRequest
{
    public function __construct(array $request)
    {
        $this->setRequest($request);
        $this->fillTable();
    }

    public function fillTable(): void
    {
        $model = new Products();

        $order = $this->prepareOrder();
        $search = $this->prepareSearch();

        $pagination = $model
            ->searchCols($search)
            ->searchEachWordInLine('name', $this->search['value'] ?: '')
            ->orderCol($order['column'], $order['dir'])
            ->paginate($this->length, ['*'], 'page', ($this->start / $this->length) + 1);

        $this->setData($pagination->items());
        $this->setRecordsTotal($model->count());
        $this->setRecordsFiltered($pagination->total());
    }

    private function prepareSearch(): array
    {
        $search = [];

        foreach ($this->columns as $col)
        {
            if($col['search']['value'])
                $search[] = ['col' => $col['data'], 'val' => $col['search']['value']];
        }

        return $search;
    }

    private function prepareOrder()
    {
        $order = ['column' => '', 'dir' => ''];

        if(isset($this->order[0])){
            $order['column'] = $this->columns[$this->order[0]['column']]['data'];
            $order['dir'] = $this->order[0]['dir'];
        }

        return $order;
    }

}
