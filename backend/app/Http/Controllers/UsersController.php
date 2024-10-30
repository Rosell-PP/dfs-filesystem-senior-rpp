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
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Registra un usuario en la App
     *
     * @param RegisterUserRequest $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function registerUser(RegisterUserRequest $request)
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            // Tomo los datos validados
            $data = $request->validated();

            // Guardo el nuevo usuario en la base de datos
            $user = User::create([
                "name" => $data["username"],
                "email" => $data["email"],
                "password" => $data["password"],
            ]);

            // Devuelvo una respuesta
            if ($user) {
                return response()->json([
                    "success"   => true,
                    "user"      => $user,
                ], 401);
            } else {
                return response()->json([
                    "success"   => false,
                ], 201);
            }
        }

        // En caso contrario se response Bad Request
        return response(null, 400);
    }
}
