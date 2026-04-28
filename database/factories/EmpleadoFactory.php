<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'       => fake()->name(),
            'telefono'     => fake()->numerify('3#########'),
            'cargo'        => fake()->randomElement(['Vendedor', 'Cajero', 'Supervisor']),
            'departamento' => fake()->randomElement(['Ventas', 'Caja', 'Bodega']),
            'salario'      => fake()->randomFloat(2, 1200000, 4000000),
            'estado'       => 'activo',
        ];
    }
}