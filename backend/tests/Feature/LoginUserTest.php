<?php

/**
 * Test LoginUserTest
 *
 * Para probar funcionamiento de la autenticación de usuarios
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica la validación del formulario de login
     */
    public function testValidateLoginForm(): void
    {
        $url = "/api/users/login";

        $payload = [
            'email' => 'testing',                    // Wrond email
            'password' => 'password',                // Weak password
        ];

        $response = $this->postJson($url, $payload);
        
        // Verifica que se hayan disparado errores de validación
        $response->assertStatus(422);

        // Verifica que los errores sean los esperados  
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Verifica la autenticación del usuario
     */
    public function testLoginUser(): void
    {
        $url = "/api/users/register";
        $payload = [
            'username' => 'Testing Fake User',
            'email' => 'testing@fake.email.com',
            'password' => '1Qaz2wsx*-+',
            'password_confirmation' => '1Qaz2wsx*-+',
        ];
        $response = $this->postJson($url, $payload);
        $response->assertStatus(201);

        $payload = [
            'email' => 'testing@fake.email.com',
            'password' => '1Qaz2wsx*-+',
        ];
        $url = "/api/users/login";

        $response = $this->postJson($url, $payload);
        // Verifico que se haya autenticado correctamente
        $response->assertStatus(200);

        // Verifico que la respuesta tenga el formato correcto
        $response->assertjsonStructure(["success", "user"]);

        // Verifico los datos del usuario autenticado
        $response->assertJson([
            "user" => [
                'name' => 'Testing Fake User',
                'email' => 'testing@fake.email.com',
            ]
        ]);
    }
}
