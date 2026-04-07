<?php

namespace App\Exports;

use App\Http\Resources\Exports\PurchaseExportResource;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchasesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
            $purchases = Purchase::whereBetween('date_bill', [$this->from, $this->to])->get();
            return $purchases->map(function ($purchase) {
                return new PurchaseExportResource($purchase);
            });
        }
        return Purchase::all()->map(function($purchase){
           return new PurchaseExportResource($purchase);
        });
    }

    public function headings(): array
    {
        return [
            'Numero de factura',
            'Proveedor',
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
