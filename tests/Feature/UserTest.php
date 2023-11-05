<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUsers()
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);

        $response->assertJson([
            'success' => true,
            'message' => 'Berhasil mendapatkan data'
        ]);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'no_telp',
                    'user_type',
                    'age',
                    'image_url'
                ]
            ]
        ]);
    }
}