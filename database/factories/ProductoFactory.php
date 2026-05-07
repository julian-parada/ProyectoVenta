<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->words(2, true),
            'codigo' => fake()->unique()->bothify('PROD-####'),
            'imagen' => null,
            'stock' => fake()->numberBetween(10, 100),
            'stock_minimo' => fake()->numberBetween(1, 10),
            'precio_unitario' => fake()->randomFloat(2, 5, 500),
            'status' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state(['status' => true]);
    }

    public function inactive(): static
    {
        return $this->state(['status' => false]);
    }
}