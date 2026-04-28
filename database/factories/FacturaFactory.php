<?php
namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id'      => Cliente::factory(),
            'empleado_id'     => Empleado::factory(),
            'fecha'           => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'total'           => 0, // se calculará en el seeder
            'tipo_pago'       => fake()->randomElement(['contado', 'credito']),
            'estado'          => fake()->randomElement(['pendiente', 'pagada']),
            'saldo_pendiente' => 0,
        ];
    }
}