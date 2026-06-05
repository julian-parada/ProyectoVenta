<?php
namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacturasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Factura::with('cliente', 'empleado')->get()->map(function($f) {
            return [
               'id'                => $f->id,
            'cliente'           => $f->cliente->nombre,
            'empleado'          => $f->empleado->nombre,
            'fecha'             => $f->fecha,
            'total'             => $f->total,
            'efectivo_recibido' => $f->efectivo_recibido ?? 0,
            'vuelto'            => $f->vuelto ?? 0,        // 👈
            
            'estado'            => $f->estado,
           
                
                

            ];
        });
    }

    public function headings(): array
    {
       return ['#', 'Cliente', 'Empleado', 'Fecha', 'Total', 'Efectivo Recibido', 'Vuelto',  'Estado'];
    }
}