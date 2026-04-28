<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'telefono',
        'cargo',
        'departamento',
        'salario',
        'estado',
    ];

    // Un empleado puede registrar muchas facturas
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'empleado_id');
    }
}