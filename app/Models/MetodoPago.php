<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodopagos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'registrado',
    ];

    // Un método de pago se usa en muchos pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'metodopago_id');
    }
}