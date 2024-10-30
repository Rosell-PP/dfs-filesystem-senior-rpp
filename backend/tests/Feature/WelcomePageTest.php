<?php

/**
 * Test WelcomePageTest
 *
 * Verifica si la app está respondiendo en su página de bienvenida
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    /**
     * Verifica si la app está respondiendo correctamente
     */
    public function testWelcomePage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
