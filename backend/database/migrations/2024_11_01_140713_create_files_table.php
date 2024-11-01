<?php

/**
 * Migration
 *
 * Crea la tabla para almacenar los archivos de los usuarios
 * - 1 usuario puede tener muchos archivos
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

use App\Models\User;
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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            // Nombre del archivo
            $table->string("name")
                ->unique()
                ->comment("Nombre del archivo");

            // Path del archivo en el almacenamiento donde se guarda
            $table->string("path")
                ->comment("Path del archivo en el almacenamiento donde se guarda");

            // Espacio en disco que ocupa el arhivo
            $table->double("size")
                ->comment("Espacio en disco que ocupa el arhivo");

            // Momento en que ha sido comprimido
            $table->timestamp("zipped_at")
                ->nullable()
                ->comment("Momento en que ha sido comprimido");

            // Usuario que ha subido el archivo
            $table->foreignId('user_id')
                ->comment("Usuario que ha subido el archivo")
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
