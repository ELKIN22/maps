<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('latitud', 10, 6);
            $table->decimal('longitud', 10, 6);
            $table->foreignId('tipo_id')->constrained('tipos_ubicacion')->onDelete('cascade');
            $table->boolean('destacada')->default(false);
            $table->text('descripcion')->nullable();
            $table->string('estado', 50)->default('activo');
            $table->string('imagen_destacada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};
