<?php

/**
 * Migration
 *
 * Adiciona la columna 'compressed' en la tabla files
 * para registrar el espacio que se reduce después de comprimir el archivo
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

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
        Schema::table('files', function (Blueprint $table) {
            // Verificamos si NO existe la columna "compressed"
            if (!Schema::hasColumn('files', 'compressed')) {
                // Espacio comprimido después de procesar el archivo
                $table->double("compressed")
                    ->nullable()
                    ->after("user_id")
                    ->comment("Espacio comprimido después de procesar el archivo");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            // Verificamos si existe la columna "compressed" para eliminarla
            if (Schema::hasColumn('files', 'compressed')) {
                // Espacio comprimido después de procesar el archivo
                $table->dropColumn("compressed");
            }
        });
    }
};
