<?php

/**
 * Test SendMailApiTest
 *
 * Simula el envío de un correo de prueba para probar el funcionamiento del mismo
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class SendMailApiTest extends TestCase
{
    /**
     * Send email
     */
    public function testSendEmail(): void
    {
        Mail::fake();

        Mail::assertNothingSent();
    }
}
