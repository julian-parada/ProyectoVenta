<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('facturas', function (Blueprint $table) {
        $table->decimal('efectivo_recibido', 10, 2)->nullable();
        $table->decimal('vuelto', 10, 2)->default(0)->nullable();
    });
}
};
