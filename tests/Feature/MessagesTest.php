<?php

namespace Tests\Feature;

use Tests\TestCase;

class MessagesTest extends TestCase
{
    /**
     * send messages
     *
     * @test
     * @return void
     */
    public function sendMessage()
    {
        $data = [
            'name' => 'Backend test',
            'email' => 'test@test.test',
            'message' => 'Message from back-end',
        ];

        $response = $this->postJson('/message', $data);
        $response->assertStatus(200);
    }
}
