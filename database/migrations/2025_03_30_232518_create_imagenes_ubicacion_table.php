<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('imagenes_ubicacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ubicacion_id')->constrained('ubicaciones')->onDelete('cascade');
            $table->string('url');
            $table->integer('orden');
            $table->timestamps();

            $table->unique(['ubicacion_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_ubicacion');
    }
};
