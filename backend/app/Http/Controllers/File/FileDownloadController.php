<?php

/**
 * Single Action Controller FileDownloadController
 *
 * Su funcionalidad es la descargar un archivo subido por el usuario
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    /**
     * Descarga un archivo
     *
     * @param Request $request La solicitud
     * @param File $file El archivo
     *
     * @return
     */
    public function __invoke(Request $request, File $file)
    {
        // Verificamos el almacenamiento de la app
        $path = $file->path;
        $name = $file->name;

        if (config('filesystems.default') === "s3") {
            Storage::disk('local')->put(
                $path,
                Storage::disk('s3')->get($path)
            );
        }

        return response()
            ->download(
                Storage::disk('local')->path($file->path),
                $name,
                [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . basename($name) . '"', 
                ],
            )->deleteFileAfterSend();
    }
}
