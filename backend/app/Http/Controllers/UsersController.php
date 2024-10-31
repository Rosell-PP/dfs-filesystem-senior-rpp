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

use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class UsersController extends Controller
{
    /**
     * Inicia la sesión de un usuario en la App
     *
     * @param LoginUserRequest $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function login(LoginUserRequest $request)
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            // Tomo los datos validados
            $data = $request->validated();

            if (Auth::attempt($data)) {
                $user = Auth::user();
                $token = $user->createToken('login-token', ["app:files"])->plainTextToken;

                // Devuelvo una respuesta
                return response()->json([
                    "success"  => true,
                    "token"    => $token,
                ]);
            } else {
                // Bad credentials
                return response()->json([
                    "success"  => true,
                    "error"    => Lang::get("Sus credenciales no coinciden con nuestros registros"),
                ]);
            }
        }

        // En caso contrario se response Bad Request
        return response(null, 400);
    }
}
