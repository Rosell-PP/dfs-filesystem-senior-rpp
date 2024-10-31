<?php

/**
 * Se definen las rutas del api
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * Rutas que se consumirán en el api
 */
Route::prefix("")
    ->group(function () {
        /**
         * Grupo de rutas encargadas de la gestión de los usuarios
         * y su autenticación
         */
        Route::prefix("users/")
            ->group(function () {
                // Ruta para registrar un nuevo usuario
                Route::post("register", UserRegisterController::class)->name("users-register");

                // Ruta para autenticar un usuario registrado
                Route::post("login")->name("users-login");

                // Ruta para cerrar la sesión de un usuario autenticado
                Route::post("logout")
                    ->name("users-logout")
                    ->middleware('auth:sanctum');

                // Devuelve los datos del usuario autenticado
                Route::get('/user', function (Request $request) {
                    return $request->user();
                })->middleware('auth:sanctum');
            });
    });

