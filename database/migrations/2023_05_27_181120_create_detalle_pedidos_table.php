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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');;
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');;
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->decimal('monto_total', 10, 2)->default(0.00);

            $table->unsignedBigInteger('mitad_uno')->nullable();
            $table->unsignedBigInteger('mitad_dos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
