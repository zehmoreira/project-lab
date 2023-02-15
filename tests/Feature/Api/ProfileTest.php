<?php

namespace Tests\Feature\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Tests\Traits\ApiSignIn;

class ProfileTest extends TestCase
{
    
    use ApiSignIn, RefreshDatabase;

    protected $jsonProfile = [
        'id',
        'fullname',
        'dob',
        'picture' 
    ];

    protected $jsonPicture = [
        'id',
        'picture'
    ];

    /** @test */
    public function i_can_save_my_profile()
    {

        $user = $this->signIn();

        $json = [
            'fullname' => 'Márcio Moreira',
            'dob' => Carbon::createFromFormat('d/m/Y', '12/08/1985')->toIso8601String(),
        ];

        $response = $this->putJson('/api/me/profile', $json);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->jsonProfile
        ]);

        $responseProfile = $this->getJson('/api/me/profile');
        $responseProfile->assertStatus(200);
        $responseProfile->assertJsonStructure([
            'data' => $this->jsonProfile
        ]);

    }

    /** @test */
    public function i_can_save_picture_profile()
    {
        $user = $this->signIn();

        $json = [
            'picture' => UploadedFile::fake()->image('profile.jpg')
        ];

        $response = $this->putJson('/api/me/change-picture', $json);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonPicture
        ]);

    }

    /** @test */
    public function i_cant_save_picture_with_exe_extension()
    {
        $user = $this->signIn();

        $json = [
            'picture' => UploadedFile::fake()->create('teste.exe'),
        ];

        $response = $this->putJson('/api/me/change-picture', $json);

        $response->assertStatus(422);
        
    }

    /** @test */
    public function i_cant_save_big_picture_profile()
    {
        $user = $this->signIn();

        $json = [
            'picture' => UploadedFile::fake()->create('teste.jpg', 2080),
        ];

        $response = $this->putJson('/api/me/change-picture', $json);

        $response->assertStatus(422);
        
    }

}
