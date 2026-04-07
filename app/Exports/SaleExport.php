<?php

namespace App\Exports;

use App\Http\Resources\Exports\SaleExportResource;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaleExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
        if($this->from && $this->to){
            $sales = Sale::whereBetween('date_bill', [$this->from, $this->to])->get();
            return $sales->map(function($sale){
                return new SaleExportResource($sale);
            });
        }
        return Sale::all()->map(function($sale){
            return new SaleExportResource($sale);
        });
    }

    public function headings(): array
    {
        return [
            'Numero de factura',
            'Cliente',
            'Fecha de factura',
            'Total',
            'Observacion',
            'Registrado por'
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
