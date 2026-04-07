<?php

namespace App\Exports;

use App\Http\Resources\Exports\ProductExportResource;
use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $from;
    protected $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->from && $this->to) {
            $products = Products::whereBetween('created_at', [$this->from, $this->to])->get();
            return $products->map(function ($product) {
                return new ProductExportResource($product);
            });
        }
        return Products::all()->map(function($product){
            return new ProductExportResource($product);
        });
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Nombre',
            'Descripcion',
            'Tipo de U/M',
            'U/M',
            'Precio',
            'Estado'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center']
            ],
        ];
    }
}
