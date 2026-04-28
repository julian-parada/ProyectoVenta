<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('facturas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes');
        $table->foreignId('empleado_id')->constrained('empleados');
        $table->date('fecha');
        $table->decimal('total', 10, 2);
        $table->string('tipo_pago')->nullable();
        $table->string('estado')->default('pendiente');
        $table->decimal('saldo_pendiente', 10, 2)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
