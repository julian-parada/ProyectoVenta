<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'codigo',
        'imagen',
        'stock',
        'stock_minimo',
        'precio_unitario',
        'status'
    ];

    // Un producto aparece en muchos detalles de factura
    public function detalles()
    {
        return $this->hasMany(Detalle::class, 'producto_id');
    }
}