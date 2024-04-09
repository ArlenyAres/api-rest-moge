<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Http\UploadedFile;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function testRegister()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(201);

        $user = User::where('name', $data['name'])
                    ->where('email', $data['email'])
                    ->first();

        $this->assertNotNull($user, 'User not found in the database');
        $this->assertTrue(preg_match('/^images\/users\/.*\.jpg$/', $user->image_path) === 1, 'Image path does not match the expected pattern');
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password')
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => $password
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token',
                    'user' => [
                        'name',
                        'email'
                    ]
                ]
            ]);
    }

    public function test_user_can_logout()
{
    $user = User::create([
        'name' => 'usuario',
        'email' => 'l@gmail.com',
        'password' => Hash::make('123456789')
    ]);

    $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->postJson('api/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

    if ($response->getStatusCode() != 200) {
        $errors = $response->json()['message'];
        var_dump($errors);
    }

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Logged out successfully']);
    $this->assertEmpty($user->fresh()->tokens);
}
}
