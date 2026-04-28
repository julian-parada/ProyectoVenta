<?php
namespace Database\Factories;

use App\Models\MetodoPago;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'metodopago_id' => MetodoPago::factory(),
            'monto'         => fake()->randomFloat(2, 50, 1000),
            'fecha_pago'    => fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
        ];
    }
}