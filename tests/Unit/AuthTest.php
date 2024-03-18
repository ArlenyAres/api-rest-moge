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
        // relleno datos para que cree un usuario a partir de lo que le hemos establecido
        $userData = [
            'name' => 'usuario',
            'email' => 'l@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];
    
        $response = $this->postJson('api/register', $userData);
    
    // Si la respuesta no es 200, mostramos los errores para que sea mas facil verificar cual es el problema en el testeo
        if ($response->getStatusCode() != 201) {
            $errors = $response->json()['data'];
            var_dump($errors);
        }
    
        $response->assertStatus(201);
    
        // se ha creado en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => $userData['email']
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
    // creo un usuario fake que ya utilice en el register
    $user = User::create([
        'name' => 'usuario',
        'email' => 'l@gmail.com',
        'password' => Hash::make('123456789')
    ]);

    // usuario con token
    $token = $user->createToken('TestToken')->plainTextToken;

    // solicitud post para que se lleve a la ruta a partir de la autorización
    $response = $this->getJson('api/logout', [
        'Authorization' => 'Bearer ' . $token
    ]);

    if ($response->getStatusCode() != 200) {
        $errors = $response->json()['message'];
        var_dump($errors);
    }

    // respuesta!
    $response->assertStatus(200);
    $response->assertJson(['message' => 'Logged out successfully']);
    $this->assertEmpty($user->fresh()->tokens);
}
}
