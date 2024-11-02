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
     * Genera url temporal del archivo para poder ser descargado
     * si el almacenamiento es s3
     */
    private function getSignedUrl(File $file)
    {
        $disk = Storage::disk('s3');

        if (!$disk->exists($file->path)) {
            return response()->json([
                'message' => 'Archivo no encontrado.'
            ], Response::HTTP_NOT_FOUND);
        }  

        $url = $disk->temporaryUrl($file->path, now()->addMinutes(5));// Expira en 5 minutos

        return $url;
    }  

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
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            // Verificamos el almacenamiento de la app
            if (config('filesystems.default') === "s3") {
                Storage::disk('local')->put(
                    $file->path,
                    Storage::disk('s3')->get($file->path)
                );
            }
            
            return response()->download(Storage::disk('local')->get($file->path));
        }

        // En caso contrario se response Bad Request
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
