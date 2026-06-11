<?php
namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Producto::select('id', 'nombre', 'codigo', 'stock', 'stock_minimo', 'precio_unitario', 'estado')->get();
    }

    public function headings(): array
    {
        return ['#', 'Nombre', 'Código', 'Stock', 'Stock Mínimo', 'Precio Unitario', 'Estado'];
    }
}