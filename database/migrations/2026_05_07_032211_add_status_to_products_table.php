<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_status_to_products_table.php
public function up(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->boolean('status')->default(true)->after('id');
    });
}

public function down(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
