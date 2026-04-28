<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'         => fake()->words(2, true),
            'codigo'         => fake()->unique()->bothify('PROD-####'),
            'imagen'         => null,
            'stock'          => fake()->numberBetween(10, 100),
            'stock_minimo'   => fake()->numberBetween(1, 10),
            'precio_unitario'=> fake()->randomFloat(2, 5, 500),
        ];
    }
}