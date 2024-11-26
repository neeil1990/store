<?php


namespace App\Lib\Sale;

use App\Lib\DataTable\DataTableRequest;
use \App\Models\Products;
use Illuminate\Database\Eloquent\Builder;

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

        $fullTextSearch = $this->fullTextLogic($this->search['value'] ?: "");
        $fbo = request('fbo');

        $pagination = $model
            ->selectEmployee()
            ->searchCols($search)
            ->when($fullTextSearch, function(Builder $query, $search){
                $query->whereFullText(['name', 'code', 'article'], $search, ['mode' => 'boolean']);
            })
            ->when($fbo, function(Builder $query){
                $query->whereJsonContains('attributes', ['name' => 'FBO OZON', 'value' => true]);
            })
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

    protected function fullTextLogic(string $search): string
    {
        if(strlen($search) < 2)
            return "";

        if(preg_match('/[\.\-\+\*]/', $search))
            return '"' . $search . '"';

        $words = explode(' ', $search);

        foreach ($words as &$word)
            $word = '+' . $word . '*';

        return implode(' ', $words);
    }

}
