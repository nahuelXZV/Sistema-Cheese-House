<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('tipo_pedido')->nullable();
            $table->decimal('descuento', 10, 2)->nullable();
            $table->string('nombre_descuento')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('tipo_pedido');
            $table->dropColumn('descuento');
            $table->dropColumn('nombre_descuento');
        });
    }
};
