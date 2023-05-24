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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->string('tamaño')->default('familiar');
            $table->string('url_imagen');
            $table->boolean('is_active')->default(false);
            $table->string('categoria');
            $table->string('tipo_botella')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->integer('stock_maximo')->default(0);

            $table->foreignId('receta_id')->constrained('recetas')->nullable()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
