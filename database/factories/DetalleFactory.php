<?php
namespace Database\Factories;

use App\Models\Factura;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleFactory extends Factory
{
    public function definition(): array
    {
        $producto = Producto::inRandomOrder()->first();
        $cantidad = fake()->numberBetween(1, 5);

        return [
            'factura_id'  => Factura::factory(),
            'producto_id' => $producto->id,
            'cantidad'    => $cantidad,
            'subtotal'    => $cantidad * $producto->precio_unitario,
        ];
    }
}