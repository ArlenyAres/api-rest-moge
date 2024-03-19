<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // testea si se crea el usuario
    public function testCreateUser()
    {
        $userData = [
            'name' => 'Arleny',
            'email' => 'arleny@example.com',
            'password' => bcrypt('password'),
            'image' => 'profile.jpg',
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);
    }

    // recoge los usuarios
    public function testGetAllUsers()
    {
        User::factory()->count(5)->create();

        $users = User::all();

        $this->assertCount(25, $users);
    }

    // recoge un usuario
    public function testGetSingleUser()
    {
        $user = User::factory()->create();

        $foundUser = User::find($user->id);

        $this->assertEquals($user->id, $foundUser->id);
    }

    // actualiza un usuario
    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $newName = 'Jane Doe';

        $user->name = $newName;
        $user->save();

        $updatedUser = User::find($user->id);

        $this->assertEquals($newName, $updatedUser->name);
    }

    // elimina un usuario
    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    public function test_getSubscribedEvents_withToken()
    {
        // Crear un usuario para autenticar
        $user = User::create([
            'name' => 'Arleny',
            'email' => 'arle@example.com',
            'password' => Hash::make('password'),
        ]);
    
        $token = $user->createToken('TestToken')->plainTextToken;
    
        $event = Event::create([
            'title' => 'Evento de prueba',
            'category_id' => 1,
            'description' => 'Descripción del evento de prueba',
            'date' => '2021-12-31',
            'location' => 'Ubicación del evento de prueba',
            'user_id' => 2,
            'image' => 'event.jpg',
        ]);
    
        $responseRegister = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/events/{$event->id}/register");
    
        $responseRegister->assertStatus(201);
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/{$user->id}/subscribed-events");
    
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data',
        ]);
        $response->assertJsonStructure([
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'category_id',
                    'user_id',
                    'date',
                    'location'
                ]
            ]
        ]);
    }
}