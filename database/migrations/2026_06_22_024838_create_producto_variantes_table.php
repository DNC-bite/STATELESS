<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_variantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('color');        // nombre del color ej: "Negro"
            $table->string('hex')->nullable(); // código hex ej: "#000000"
            $table->string('imagen')->nullable(); // imagen específica de esa variante
            $table->integer('stock_actual')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_variantes');
    }
};