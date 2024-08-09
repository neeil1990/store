<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class SuppliersDataTable
{
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('article'),
            Column::make([
                'title' => __('Наименование'),
                'data' => 'name',
            ]),
            Column::make('stocks'),
            Column::make('reserve'),
            Column::make('inTransit'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }
}
