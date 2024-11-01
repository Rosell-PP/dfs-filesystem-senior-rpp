<?php

/**
 * Single Action Controller UserLoginController
 *
 * Su funcionalidad es la de autenticar un usuario registrado en la App
 * devolviendo el token de autenticación del mismo
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Response;

class UserLoginController extends Controller
{
    /**
     * Inicia la sesión de un usuario en la App
     *
     * @param LoginUserRequest $request La solicitud
     *
     * @return JsonResponse La respuesta en formato Json
     */
    public function __invoke(LoginUserRequest $request) : JsonResponse
    {
        // La solicitud debe hacerse solicitando la respuesta en Json
        if ($request->wantsJson()) {
            // Tomo los datos validados
            $data = $request->validated();

            if (Auth::attempt($data)) {
                $user = Auth::user();

                $user["token"] = $user->createToken('login-token', ["app:files"])->plainTextToken;

                // Devuelvo una respuesta
                return response()->json([
                    "success"  => true,
                    "user"     => $user,
                ], Response::HTTP_OK);
            } else {
                // Bad credentials
                return response()->json([
                    "success"  => true,
                    "errors"   => [
                        "email" => [
                            Lang::get("Sus credenciales no coinciden con nuestros registros")
                        ]
                    ],
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        // En caso contrario se response Bad Request
        return response(null, Response::HTTP_BAD_REQUEST);
    }
}
