<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

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

    public function testGetAllUsers()
    {
        User::factory()->count(5)->create();

        $users = User::all();

        $this->assertCount(5, $users);
    }

    public function testGetSingleUser()
    {
        $user = User::factory()->create();

        $foundUser = User::find($user->id);

        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $newName = 'Jane Doe';

        $user->name = $newName;
        $user->save();

        $updatedUser = User::find($user->id);

        $this->assertEquals($newName, $updatedUser->name);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}