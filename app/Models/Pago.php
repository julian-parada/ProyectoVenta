<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'factura_id',
        'monto',
        'fecha_pago',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}