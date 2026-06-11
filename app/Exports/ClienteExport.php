<?php
namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClienteExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Cliente::select('id', 'nombre', 'n_identificacion', 'telefono', 'email', 'direccion', 'estado')->get();
    }

    public function headings(): array
    {
        return ['#', 'Nombre', 'Identificación', 'Teléfono', 'Email', 'Dirección', 'Estado'];
    }
}