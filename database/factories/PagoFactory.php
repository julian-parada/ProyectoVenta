<?php
namespace Database\Factories;

use App\Models\MetodoPago;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    // database/factories/PagoFactory.php
    public function definition(): array
    {
        return [
            'factura_id' => \App\Models\Factura::inRandomOrder()->first()?->id
                ?? \App\Models\Factura::factory()->create()->id,
            'metodopago_id' => \App\Models\MetodoPago::inRandomOrder()->first()?->id,
            'monto' => fake()->randomFloat(2, 10, 2000),
            'fecha_pago' => fake()->date(),
        ];
    }
}