<?php
namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacturaExport implements FromArray, WithHeadings
{
    protected $factura;

    public function __construct($factura)
    {
        $this->factura = $factura;
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->factura->detalles as $detalle) {
            $rows[] = [
               $this->factura->id,
            $this->factura->cliente->nombre,
            $this->factura->empleado->nombre,
            $this->factura->fecha,
            $detalle->producto->nombre,
            $detalle->cantidad,
            $detalle->producto->precio_unitario,
            $detalle->subtotal,
            $this->factura->total,
            $this->factura->efectivo_recibido ?? 0,
            $this->factura->vuelto ?? 0,      
           
            $this->factura->estado,
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
       return ['#', 'Cliente', 'Empleado', 'Fecha', 'Producto', 'Cantidad', 'Precio Unit.', 'Subtotal', 'Total', 'Efectivo Recibido', 'Vuelto',  'Estado'];
    }
}