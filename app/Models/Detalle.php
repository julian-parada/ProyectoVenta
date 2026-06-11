<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    // Ojo: la tabla en BD se llama 'detalles', no 'detallefacturas'
    protected $table = 'detalles';

    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad', 
        'subtotal',
    ];

    // Pertenece a una factura
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }

    // Pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

     public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}