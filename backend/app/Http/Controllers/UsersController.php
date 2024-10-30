<?php

/**
 * Controller UsersController
 *
 * Gestiona lo relacionado con los usuarios:
 *  - registro,
 *  - inicio 
 *  - y cierre de sesión
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Registra un usuario en la App
     *
     * @param Request $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function registerUser(Request $request)
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            
            return response()->json([
                "success"   => true,
            ]);
        }

        // En caso contrario se response Bad Request
        return response(null, 400);
    }
}
