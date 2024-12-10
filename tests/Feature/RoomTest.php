<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\Type;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RoomTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_getAllRooms_success(): void
    {
        Room::factory()->create();

        $response = $this->getJson('/api/rooms');

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->has('data', 1, function (AssertableJson $data) {
                    $data->hasAll(['id', 'name', 'image', 'min_capacity', 'max_capacity', 'type'])
                        ->whereAllType([
                            'id' => 'integer',
                            'name' => 'string',
                            'image'=> 'string',
                            'min_capacity' => 'integer',
                            'max_capacity' => 'integer',
                            'type' => 'array',
                        ]);
                    });
            });
    }
}
