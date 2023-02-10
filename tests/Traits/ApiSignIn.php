<?php

namespace Tests\Traits;

use App\Models\User;
use Laravel\Passport\Passport;

trait ApiSignIn
{
    public function signIn() : User
    {
        $user = User::factory()
            ->create();

        Passport::actingAs($user);

        return $user;
    }
}