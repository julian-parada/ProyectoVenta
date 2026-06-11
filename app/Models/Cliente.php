<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'n_identificacion',
        'status'
    ];

    // Un cliente puede tener muchas facturas
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'cliente_id');
    }

     public function detalles()
    {
        return $this->hasMany(Detalle::class, 'cliente_id');
    }


}