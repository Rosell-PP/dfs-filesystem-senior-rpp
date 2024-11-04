<?php

/**
 * Single Action Controller FilesListController
 *
 * Su funcionalidad es la devolver el listado de archivos subidos por el usuario
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FilesListController extends Controller
{
    /**
     * Devuelve lista de archivos
     *
     * @param Request $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function __invoke(Request $request) : JsonResponse
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            // Posibles parámetros relacionados con el listado
            $itemsPerPage = $request->input("itemsPerPage", 10);
            $search = $request->input("search", "");
            $sortBy = $request->input("sortBy", [[]])[0] ?? [];

            // Para ordenar por defecto último archivo subido
            if (count($sortBy) == 0) {
                $sortBy = ['key'=>'created_at', 'order'=>'desc'];
            }
            
            // Construyo la consulta para obtener los archivos del usuario
            $query = File::query()
                // Filtro los archivos del usuario autenticado
                ->where("user_id", Auth::user()->id)

                // Para filtrar por el criterio de búsqueda
                ->when($search, function ($query, $search) {
                    $search = strtolower(trim($search));
                    return $query->whereRaw('LOWER(name) LIKE ?', ["%$search%"])
                        ->orWhereRaw('LOWER(path) LIKE ?', ["%$search%"]);
                })

                // Para ordenar por la columna especificada
                ->when($sortBy, function ($query, $sortBy) {
                    return $query->orderBy($sortBy['key'], $sortBy['order']);
                });

            $files = $query->paginate($itemsPerPage == -1 ? File::count():$itemsPerPage);

            return response()->json([
                "success"   => true,
                "files"     => $files
            ]);
        }

        // En caso contrario se response Bad Request
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
