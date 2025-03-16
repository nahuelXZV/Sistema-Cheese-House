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
        Schema::create('combo_productos', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->default(1);
            $table->unsignedBigInteger('combo_id');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('combo_id')->references('id')->on('combos');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_productos');
    }
};
