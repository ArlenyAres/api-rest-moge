<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;    

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_user_can_register()
    {
        // Creamos un usuario utilizando Faker
        $user = User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('123456789')
        ]);
    
        // Realizamos una solicitud de registro
        $response = $this->postJson('api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '123456789'
        ]);
    
        // Verificamos que la respuesta sea exitosa
        $response->assertStatus(201);
    
        // Verificamos que se haya creado un nuevo usuario en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
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
        //
    }
}
