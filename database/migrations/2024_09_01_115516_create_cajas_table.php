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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('fecha')->unique();
            $table->string('dia');
            $table->decimal('cantidad_deposito', 8, 2)->default(0.00);
            $table->decimal('transpaso_caja_chica', 8, 2)->default(0.00);
            $table->decimal('adicion_caja_chica', 8, 2)->default(0.00);
            $table->decimal('caja_dia_siguiente', 8, 2)->default(0.00);
            $table->decimal('total_ventas', 8, 2)->default(0.00);
            $table->decimal('cortesia', 8, 2)->default(0.00);
            $table->decimal('falto', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
