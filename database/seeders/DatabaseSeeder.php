<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Factura;
use App\Models\Detalle;
use App\Models\MetodoPago;
use App\Models\Pago;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Datos base
        $metodos   = MetodoPago::factory()->count(3)->create();
        $empleados = Empleado::factory()->count(5)->create();

        // ✅ Productos y clientes con estado, FUERA del loop
        $productos = Producto::factory(15)->active()->create()
            ->merge(Producto::factory(5)->inactive()->create());

        $clientes = Cliente::factory(15)->active()->create()
            ->merge(Cliente::factory(5)->inactive()->create());

        // 2. Por cada cliente, crear facturas con detalles y pagos
        $clientes->each(function ($cliente) use ($productos, $empleados, $metodos) {

            Factura::factory()->count(rand(1, 3))->create([
                'cliente_id'  => $cliente->id,
                'empleado_id' => $empleados->random()->id,
            ])->each(function ($factura) use ($productos, $metodos) {

                // Detalles
                $total = 0;
                for ($i = 0; $i < rand(1, 4); $i++) {
                    $producto = $productos->random();
                    $cantidad = rand(1, 5);
                    $subtotal = $cantidad * $producto->precio_unitario;

                    Detalle::create([
                        'factura_id'  => $factura->id,
                        'producto_id' => $producto->id,
                        'cantidad'    => $cantidad,
                        'subtotal'    => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                // Actualizar total de la factura
                $factura->update([
                    'total'           => $total,
                    'saldo_pendiente' => $factura->tipo_pago === 'credito' ? $total : 0,
                ]);

                // ✅ Pago con factura_id incluido
                Pago::create([
                    'factura_id'    => $factura->id,
                    'metodopago_id' => $metodos->random()->id,
                    'monto'         => $total,
                    'fecha_pago'    => now()->format('Y-m-d'),
                ]);
            });
        });
    }
}