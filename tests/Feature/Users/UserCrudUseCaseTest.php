<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Shared\SimpleEntities\SimpleEntityTestBase;
use Tests\TestCase;

class UserCrudUseCaseTest extends SimpleEntityTestBase
{

    protected $model = User::class;
    protected $routeNameBase = 'users';

    public function test_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newRecord = app()->make($this->model)::factory()->withPasswordConfirmation()->make();

        $response = $this->post(route($this->routeNameBase . '.create'), [
            'name' => $newRecord->name,
            'email' => $newRecord->email,
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertOk()->assertSee($newRecord->email);
    }
}
