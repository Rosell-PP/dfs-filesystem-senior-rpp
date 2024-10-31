<?php

/**
 * Single Action Controller UserRegisterController
 *
 * Su funcionalidad es la de registrar un nuevo usuario en la App
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;

class UserRegisterController extends Controller
{
    /**
     * Registra un nuevo usuario en la App
     *
     * @param RegisterUserRequest $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function __invoke(RegisterUserRequest $request) : JsonResponse
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
                ], 201);
            } else {
                return response()->json([
                    "success"   => false,
                ], 200);
            }
        }

        // En caso contrario se response Bad Request
        return response(null, 400);
    }
}
