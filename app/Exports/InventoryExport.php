<?php

namespace App\Exports;

use App\Http\Resources\Exports\InventoryExportResource;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
            $inventory = Inventory::whereBetween('created_at', [$this->from, $this->to])->get();
            return $inventory->map(function ($inventory) {
                return new InventoryExportResource($inventory);
            });
        }
        return Inventory::all()->map(function($inventory) {
            return new InventoryExportResource($inventory);
        });
    }

    public function headings(): array
    {
        return [
            'Codigo de inventario',
            'Producto',
            'Stock',
            'Valor total',
            'Descripcion',
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
