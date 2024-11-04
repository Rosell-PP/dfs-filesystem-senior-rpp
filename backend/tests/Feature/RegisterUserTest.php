<?php

/**
 * Test RegisterUserTest
 *
 * Para probar funcionamiento de la funcionalidad de registro de usuario
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba la validación de la solicitud para Registrar un usuario
     */
    public function testValidateRegisterForm(): void
    {
        $url = "/api/users/register";

        $payload = [
            'username' => '',                           // Is required
            'email' => 'testing',                    // Wrond email
            'password' => 'password',                   // Weak password
            'password_confirmation' => 'passwordaa',    // Mismatch with password
        ];

        $response = $this->postJson($url, $payload);
        
        // Verifica que se hayan disparado errores de validación
        $response->assertStatus(422);

        // Verifica que los errores sean los esperados  
        $response->assertJsonValidationErrors(['username', 'email', 'password']);
        
        // // Verifica que el usuario se haya creado en la base de datos
        // $this->assertDatabaseHas('users', [  
        //     'email' => 'testing@fake.email.com',
        // ]); 
    }

    /**
     * Prueba la funcionalidad para Registrar un usuario
     */
    public function testRegisterUser(): void
    {
        $url = "/api/users/register";

        $payload = [
            'username' => 'Testing Fake User',
            'email' => 'testing@fake.email.com',
            'password' => '1Qaz2wsx*-+',
            'password_confirmation' => '1Qaz2wsx*-+',
        ];

        $response = $this->postJson($url, $payload);
        
        // Verifica que se hayan disparado errores de validación
        $response->assertStatus(201);

        // Verifica que el usuario se haya creado en la base de datos
        $this->assertDatabaseHas('users', [  
            'email' => 'testing@fake.email.com',
        ]); 
    }
}
