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
            // Construyo la consulta para obtener los archivos del usuario
            $query = File::query()
                ->where("user_id", Auth::user()->id)
                ->when($request->get('search'), function ($query, $search) {
                    $search = strtolower(trim($search));

                    return $query->whereRaw('LOWER(name) LIKE ?', ["%$search%"])
                        ->orWhereRaw('LOWER(path) LIKE ?', ["%$search%"]);
                })
                ->when($request->get('sort'), function ($query, $sortBy) {
                    return $query->orderBy($sortBy['key'], $sortBy['order']);
                });

            $files = $query->paginate($request->get('limit') == -1 ? File::count():$request->get('limit', 10));

            return response()->json([
                "success"   => true,
                "files"     => $files
            ]);
        }

        // En caso contrario se response Bad Request
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
