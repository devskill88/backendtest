<?php 

namespace Tests\Feature\Shared\SimpleEntities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

abstract class SimpleEntityTestBase extends TestCase
{
    protected $model;
    protected $routeNameBase;

    public function test_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newRecord = app()->make($this->model)::factory()->make();

        $response = $this->post(route($this->routeNameBase . '.create'), $newRecord->toArray());

        $response->assertOk()->assertSee($newRecord->email);

    }

    public function test_index()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $records = app()->make($this->model)::factory(10)->create();
        
        $response = $this->get(route($this->routeNameBase . '.index') . '?per_page=999999');

        $response->assertOk();

        foreach ($records as $record){
            $response->assertSee($record->email);
        }
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $record = app()->make($this->model)::factory(1)->create();

        $response = $this->get(route($this->routeNameBase . '.show', [$record->first()->id]));

        $record = $record->except(['id'])->first();

        $response->assertSee($record->name);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $record = app()->make($this->model)::factory()->create();
        $editedRecord = app()->make($this->model)::factory()->make();

        $response = $this->put(route($this->routeNameBase . '.update', [$record->id]), $editedRecord->toArray());

        $record->refresh();

        $response->assertOk();
        $this->assertTrue($record->name == $editedRecord->name);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $record = app()->make($this->model)::factory()->create();
        $response = $this->delete(route($this->routeNameBase . '.remove', [$record->id]));

        $response->assertOk();
        $isDeleted = app()->make($this->model)::find($record->id);
        $this->assertTrue(is_null($isDeleted));

    }


}