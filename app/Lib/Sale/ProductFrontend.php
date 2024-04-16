<?php


namespace App\Lib\Sale;

use \App\Models\Products;

class ProductFrontend
{
    protected $model;
    protected $pagination;
    protected $columns;
    protected $order;
    protected $start;
    protected $length;
    protected $search;

    public function __construct(array $request)
    {
        foreach ($request as $key => $val)
            if(property_exists($this, $key))
                $this->$key = $val;

        $this->model = new Products();

        $this->initPagination();
    }

    private function initPagination()
    {
        $order = $this->prepareOrder();
        $search = $this->prepareSearch();

        $this->pagination = $this->model
            ->whereAny([
                'name',
                'article',
                'salePrices',
            ], 'LIKE', '%'.$this->search['value'].'%')
            ->searchCol($search)
            ->orderCol($order['column'], $order['dir'])
            ->paginate($this->length, ['*'], 'page', ($this->start / $this->length) + 1);
    }

    private function prepareSearch()
    {
        $search = [];

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

    public function items(): array
    {
        return $this->pagination->items();
    }

    public function error(): string
    {
        return '';
    }

    public function total(): int
    {
        return $this->model->count();
    }

    public function records(): int
    {
        return $this->pagination->total();
    }
}
