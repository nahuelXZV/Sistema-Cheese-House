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
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_compra_id');
            $table->foreign('nota_compra_id')->references('id')->on('nota_compras')->onDelete('cascade');
            $table->unsignedBigInteger('ingrediente_id')->nullable();
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2)->default(0.00);
            $table->decimal('precio_unidad', 10, 2)->default(0.00);
            $table->decimal('monto_total', 10, 2)->default(0.00);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_compras');
    }
};
