<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // testea si se crea el usuario
    public function testCreateUser()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
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
}