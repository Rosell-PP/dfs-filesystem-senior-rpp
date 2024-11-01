<?php

/**
 * Modelo File
 *
 * Representa un archivo que el usuario ha subido a la App
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Propiedades rellenables
     */
    public $fillable = [
        "name",     // Nombre del archivo
        "path",     // Path del archivo en el almacenamiento donde se guarda
        "size",     // Espacio en disco que ocupa el arhivo
    ];
}
