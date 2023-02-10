<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;


    public function setUp(): void
    {
        $this->defaultHeaders = [
            'Content-type' => 'application/json'
        ];

        parent::setUp();
    }

    /** @test */
    public function visitante_rejeitados()
    {
        $response = $this->getJson('/api/');

        $response->assertStatus(401);

    }

    /** @test */
    public function solicitacao_nova_senha()
    {

        $user = User::factory()->create();

        $response = $this->postJson('/api/forgot-password', [
            'email' => $user->email
        ]);

        $response->assertStatus(200);

        $newPassword = fake()->password(8,8);

        $responseNewPassword = $this->postJson('/api/reset-password', [
            'code' => $response['code'],
            'password' => $newPassword,
            'confirmpassword' => $newPassword,
        ]);

        $responseNewPassword->assertStatus(200);
    }

    /** @test */
    public function send_reset_password_wrong_new_password()
    {

        $user = User::factory()->create();

        $response = $this->postJson('/api/forgot-password', [
            'email' => $user->email
        ]);

        $response->assertStatus(200);

        $newPassword = fake()->password(8,8);

        $responseNewPassword = $this->postJson('/api/reset-password', [
            'code' => $response['code'],
            'password' => $newPassword,
            'confirmpassword' => '--',
        ]);

        $responseNewPassword->assertStatus(200);
    }
}
