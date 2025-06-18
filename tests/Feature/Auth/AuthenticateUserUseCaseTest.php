<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticateUserUseCaseTest extends TestCase
{

    public function test_authenticate_user()
    {

        $user = User::factory()->create();
        
        $response = $this->post(route('auth.getToken', [
            'email' => $user->email,
            'password' => '123456'
        ]));

        $response->assertOk()->assertJsonStructure(['success', 'data' => ['token']]);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('auth.logOut'));

        $response->assertOk();
    }

}
