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
        Schema::create('reporte_ingredientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingrediente_id')->nullable();
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->string('nombre');
            $table->double('precio', 10, 3);
            $table->string('fecha');
            $table->decimal('stock_inicial', 10, 3);
            $table->decimal('stock_ventas', 10, 3);
            $table->decimal('stock_compras', 10, 3);
            $table->decimal('stock_final', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_ingredientes');
    }
};
