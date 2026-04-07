<?php

namespace App\Exports;

use App\Http\Resources\Exports\PurchaseExportResource;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseByIdExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $bill;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Purchase $bill)
    {
        $this->bill = $bill;
    }

    public function array(): array
    {
        $details = [
            ['Numero de factura: '.$this->bill->number_bill],
            ['Proveedor: '.$this->bill->provider],
            ['Fecha de factura: '.$this->bill->date_bill],
            ['Registrado por: '.$this->bill->user->name]
        ];

        $empty = [['']];

        $totals = [
            ['Subtotal: C$', '', '', '', $this->bill->subtotal],
            ['Descuento: C$', '', '', '', $this->bill->discount],
            ['Total: C$', '', '', '', $this->bill->total]
        ];

        $information_end = [
            ['Observacion: '],
            [$this->bill->observation],
        ];

        $productDetails = [
            ['Producto', 'Cantidad', 'Precio', 'Total', 'Observacion']
        ];

        foreach ($this->bill->purchase_details as $detail){
            $productDetails[] = [
                $detail->product->name,
                $detail->quantity,
                $detail->price,
                $detail->total,
                $detail->observation
            ];
        }

        return array_merge($details, $empty, $productDetails, $empty, $totals, $empty, $information_end);
    }

    public function styles(Worksheet $sheet)
    {
        $productCount = count($this->bill->purchase_details);
        $startRowForTotals = 8 + $productCount;
        $startRowForDetails = $startRowForTotals + 4;

        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('A4:E4');

        $sheet->mergeCells("A{$startRowForTotals}:D{$startRowForTotals}");
        $sheet->mergeCells("A".($startRowForTotals + 1).":D".($startRowForTotals + 1));
        $sheet->mergeCells("A".($startRowForTotals + 2).":D".($startRowForTotals + 2));
        $sheet->mergeCells("A".($startRowForDetails).":E".($startRowForDetails + 2));
        return [
            6    => array_merge(['alignment' => ['horizontal' => 'center'], 'font' => ['bold' => true],]),
            $startRowForTotals => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
            $startRowForTotals + 1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
            $startRowForTotals + 2 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
        ];
    }

    public function headings(): array
    {
        return [];
    }
}
