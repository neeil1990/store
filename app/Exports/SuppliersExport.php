<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersExport implements FromCollection, Responsable, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $supplier;

    private $fileExt = '.xlsx';

    private $fileName = 'export.xlsx';

    private $writerType = Excel::XLSX;

    private $row = 0;

    public function __construct(Collection $supplier)
    {
        $supplier = $supplier->filter(function($val) {
            return $val->toBuy > 0;
        });

        $this->fileName = implode('-', [$supplier->value('suppliers.name'), Carbon::now()]) . $this->fileExt;

        $this->supplier = $supplier;
    }

    public function collection()
    {
        return $this->supplier;
    }

    public function map($supplier): array
    {
        $this->row += 1;

        return [
            $this->row,
            $supplier->code,
            $supplier->article,
            $supplier->name,
            $supplier->suppliers->name,
            $supplier->toBuy,
            $supplier->uoms->name,
            $supplier->buyPrice,
            $supplier->buyPrice * $supplier->toBuy,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            __('Код'),
            __('Артикул'),
            __('Наименование товаров'),
            __('Поставщик'),
            __('Кол-во'),
            __('Ед. изм.'),
            __('Закупочная цена'),
            __('Итого'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
