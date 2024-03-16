<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    // public function test_user_can_register_for_event()
    // {
    //     // Creamos un usuario
    //     $user = User::factory()->create();

    //     // Simulamos la autenticación del usuario
    //     $this->actingAs($user);

    //     // Creamos un evento
    //     $event = Event::factory()->create();

    //     // Realizamos una solicitud para registrar al usuario en el evento
    //     $response = $this->postJson("/api/events/{$event->id}/register");

    //     // Verificamos que la respuesta tenga el código de estado esperado (201)
    //     // y que el usuario esté registrado en el evento
    //     $response->assertStatus(201)
    //              ->assertJson([
    //                  'event_id' => $event->id,
    //                  'user_id' => $user->id
    //              ]);

    //     // Verificamos que la inscripción haya sido creada en la base de datos
    //     $this->assertDatabaseHas('registrations', [
    //         'event_id' => $event->id,
    //         'user_id' => $user->id
    //     ]);
    // }

    // public function test_user_can_unregister_from_event()
    // {
    //     // Creamos un usuario
    //     $user = User::factory()->create();

    //     // Simulamos la autenticación del usuario
    //     $this->actingAs($user);

    //     // Creamos un evento y registramos al usuario en él
    //     $event = Event::factory()->create();
    //     $registration = Registration::factory()->create([
    //         'event_id' => $event->id,
    //         'user_id' => $user->id
    //     ]);

    //     // Realizamos una solicitud para desinscribir al usuario del evento
    //     $response = $this->deleteJson("/api/events/{$event->id}/unregister");

    //     // Verificamos que la respuesta tenga el código de estado esperado (204)
    //     // y que el usuario esté desinscrito del evento
    //     $response->assertStatus(204);

    //     // Verificamos que la inscripción haya sido eliminada de la base de datos
    //     $this->assertDatabaseMissing('registrations', [
    //         'id' => $registration->id
    //     ]);
    // }
}
