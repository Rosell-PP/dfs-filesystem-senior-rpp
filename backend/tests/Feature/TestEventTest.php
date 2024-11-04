<?php

/**
 * Test TestEventTest
 * 
 * Para probar el funcionamiento de la comunicación en tiempo real con el frontend
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace Tests\Feature;

use App\Events\TestEvent;
use Tests\TestCase;

class TestEventTest extends TestCase
{
    /**
     * Dispatch a TestEvent event
     */
    public function testEvent(): void
    {
        $message = "This is a message from backend test";
        event(new TestEvent($message));

        $this->assertTrue(true);
    }
}
