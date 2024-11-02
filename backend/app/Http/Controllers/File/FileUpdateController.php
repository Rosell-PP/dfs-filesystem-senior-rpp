<?php

/**
 * Single Action Controller FileUpdateController
 *
 * Su funcionalidad es la actualizar los datos de un archivo subido por el usuario
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileUpdateController extends Controller
{
    /**
     * Actualiza los datos de un archivo subido por el usuario
     *
     * @param Request $request La solicitud
     * @param File $file El archivo
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function __invoke(Request $request, File $file) : JsonResponse
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            $name = $request->input("filename", NULL);
            if ($name) {
                $file->name = $name;
                $file->save();
            }

            return response()->json([
                "success" => true,
                "file"    => $file,
            ], Response::HTTP_OK);
        }

        // En caso contrario se response Bad Request
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
