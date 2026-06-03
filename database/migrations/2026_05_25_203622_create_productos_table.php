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
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->decimal('precio', 10, 2);
        $table->string('estado')->default('activo');
        $table->string('imagen')->nullable();
        $table->integer('stock_actual')->default(0);
        $table->integer('stock_minimo')->default(5);
        $table->integer('stock_maximo')->default(100);
        $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
        $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
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
