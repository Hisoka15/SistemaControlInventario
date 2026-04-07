<?php

namespace App\Exports;

use App\Http\Resources\Exports\UserExportResource;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
             $users = User::whereBetween('created_at', [$this->from, $this->to])->get();
            return $users->map(function ($user) {
                return new UserExportResource($user);
            });
        }
        return User::all()->map(function ($user) {
            return new UserExportResource($user);
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Rol',
            'Correo electronico',
            'Estado',
            'Ultimo inicio de sesion'
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
