<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';

    protected $fillable = [
        'cliente_id',
        'empleado_id',
        'fecha',
        'total',
        'tipo_pago',
        'estado',
        'saldo_pendiente',
    ];

    // Pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Pertenece a un empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    // Una factura tiene muchos detalles de productos
    public function detalles()
    {
        return $this->hasMany(Detalle::class, 'factura_id');
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'factura_id');
    }
}