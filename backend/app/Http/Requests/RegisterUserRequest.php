<?php

/**
 * Request RegisterUserRequest
 *
 * Valida la solicitud para registrar un usuario en la App
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Http\Requests;

use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;


class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            "username"  =>  "required|unique:users,name",
            "email"     =>  "required|email:rfc",
            "password"  =>  [
                "required",
                "confirmed",
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()
            ],
            "password_confirmation" =>  "required"
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
            "username.required"     => Lang::get("Debe especificar su nombre de usuario"),
            "username.unique"       => Lang::get("Ya existe otro usuario con ese nombre"),
            "email.required"        => Lang::get("Debe especificar una dirección de correo electrónico"),
            "email.email"           => Lang::get("La dirección de correo especificada no es válida"),
            
            "password.required"     => Lang::get("Su contraseña debe contener 8 caracteres mínimo, mayúsculas, minúsculas, números y símbolos"),
            "password.min"          => Lang::get("Su contraseña debe contener 8 caracteres como mínimo"),
            "password.letters"      => Lang::get("Su contraseña debe contener letras"),
            "password.mixed"        => Lang::get("Su contraseña debe contener mayúsculas y minúsculas"),
            "password.numbers"      => Lang::get("Su contraseña debe contener números"),
            "password.symbols"      => Lang::get("Su contraseña debe contener símbolos"),
            "password.confirmed"    => Lang::get("La confirmación de su contraseña no coincide"),
            
            "password_confirmation.required" => Lang::get("La confirmación de su contraseña no coincide"),
        ];
    }
}
