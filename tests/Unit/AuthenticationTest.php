<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login with valid credentials.
     *
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('testpassword'),
        ]);

        $requestData = [
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ];

        $response = $this->postJson('/api/auth/login', $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Logged In Successfully',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'token',
            ]);
    }

    /**
     * Test login with invalid credentials.
     *
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        $requestData = [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ];

        $response = $this->postJson('/api/auth/login', $requestData);

        $response->assertStatus(401)
            ->assertJson([
                'status' => false,
                'message' => 'Email & Password does not exist.',
            ])
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

}
