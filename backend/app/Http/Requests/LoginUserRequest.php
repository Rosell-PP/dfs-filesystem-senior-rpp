<?php

/**
 * Request LoginUserRequest
 *
 * Valida la solicitud para iniciar sesión en la App
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Si el usuario está autenticado no le permito la solicitud
        if (Auth::user()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email"     =>  "required|email:rfc",
            "password"  =>  "required",
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "email.required"        => Lang::get("Debe especificar su dirección de correo electrónico"),
            "email.email"           => Lang::get("La dirección de correo especificada no es válida"),
            "password.required"     => Lang::get("Debe especificar su contraseña para poder autenticarse"),
        ];
    }
}
