<?php

/**
 * Single Action Controller FileUploadController
 *
 * Su funcionalidad es la cargar un archivo subido por el usuario
 * - Se almacena en el almacenamiento especificado
 * - Se registra en la base de datos
 * - Una vez almacenado se procesa(se comprime) y luego se actualiza en base de datos
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */


namespace App\Http\Controllers\File;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessUploadedFileJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\UniqueConstraintViolationException;

class FileUploadController extends Controller
{
    /**
     * Guarda un archivo subido por el usuario
     *
     * @param Request $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function __invoke(Request $request) : JsonResponse
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            try {
                $name = $request->input("filename", NULL);
                $file = $request->file("file");
                $filename = $file->getClientOriginalName();
    
                $path = Storage::putFileAs('unzipped', $file, $name ?? $filename);
                if ($path) {
                    $file = Auth::user()->files()->create([
                        "name" => $name ?? $filename,   // Nombre del archivo
                        "path" => $path,                // Path del archivo en el almacenamiento donde se guarda
                        "size" => Storage::size($path), // Espacio en disco que ocupa el arhivo
                    ]);

                    // Lanzamos el job para procesar el archivo
                    ProcessUploadedFileJob::dispatch($file);
    
                    return response()->json([
                        "success" => true,
                        "file"    => $file,
                    ], Response::HTTP_OK);
                } else {
                    throw new Exception(
                        Lang::get("No se ha podido guardar el archivo. Pruebe en unos minutos")
                    );
                }
            } catch (UniqueConstraintViolationException $th) {
                return response()->json([
                    "success" => false,
                    "errors"  => [
                        "filename" => [
                            Lang::get("Ya existe un archivo en su lista de archivos con ese nombre")
                        ]
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                ]);
            } catch (Exception $e) {
                return response()->json([
                    "success" => false,
                    "errors"  => [
                        "filename" => [
                            $e->getMessage()
                        ]
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                ]);
            }
        }

        // En caso contrario se response Bad Request
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
