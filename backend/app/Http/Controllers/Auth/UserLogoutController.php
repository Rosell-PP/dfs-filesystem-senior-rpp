<?php

/**
 * Single Action Controller UserLogoutController
 *
 * Su funcionalidad es la de cerrar la sesión del usuario autenticado
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserLogoutController extends Controller
{
    /**
     * Cierra la sesión de un usuario en la App
     *
     * @param Request $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function __invoke(Request $request) : JsonResponse
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            Auth::user()->tokens()->delete();

            // Devuelvo una respuesta
            return response()->json([
                "success"  => true,
            ], Response::HTTP_OK);
        }

        // En caso contrario se response Bad Request
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
