<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MetodoPagoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'      => fake()->randomElement(['Efectivo', 'Tarjeta', 'Transferencia']),
            'descripcion' => fake()->sentence(),
            'estado'      => 'activo',
            'registrado'  => true,
        ];
    }
}