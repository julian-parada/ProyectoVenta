<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
// database/seeders/MetodoPagoSeeder.php
public function run(): void
{
    DB::table('metodos_pago')->insert([
        ['nombre' => 'Efectivo',       'estado' => 'activo', 'created_at' => now(), 'updated_at' => now()],
        ['nombre' => 'Tarjeta',        'estado' => 'activo', 'created_at' => now(), 'updated_at' => now()],
        ['nombre' => 'Transferencia',  'estado' => 'activo', 'created_at' => now(), 'updated_at' => now()],
    ]);
}
}
