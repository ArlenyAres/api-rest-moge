<?php 

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $eventData = [
            'title' => 'Evento de Prueba',
            'category_id' => 1,
            'description' => 'Descripción del evento de prueba',
            'image' => UploadedFile::fake()->image('avatar.jpg'), 
            'date' => '2021-12-31',
            'location' => 'Barcelona',
            'user_id' => 1,
            'max_assistants' => 100, 
        ];
    
        $response = $this->postJson('/api/events/create', $eventData);
        if ($response->getStatusCode() !== 201) {
            $error = $response->json();
            var_dump($error);
        }
    
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Evento creado exitosamente']);
    }

    public function test_update()
{
    $user = User::factory()->create();
    $this->actingAs($user);
    $eventData = [
        'title' => 'Evento de Prueba',
        'category_id' => 1,
        'description' => 'Descripción del evento de prueba',
        'image' => UploadedFile::fake()->image('avatar.jpg'),
        'location' => 'Barcelona',
        'user_id' => 1,
        'max_assistants' => 100,
    ];

    $responseCreate = $this->postJson('/api/events/create', $eventData);
    if ($responseCreate->getStatusCode() !== 201) {
        $errorCreate = $responseCreate->json();
        var_dump($errorCreate);
    }

    $responseCreate->assertStatus(201);
    $responseCreate->assertJson(['message' => 'Evento creado exitosamente']);

    $eventId = $responseCreate->json()['data']['id'];

    $updatedEventData = [
        'title' => 'Evento Actualizado',
        'category_id' => 2,
        'description' => 'Descripción del evento actualizado',
        'image' => UploadedFile::fake()->image('updated_avatar.jpg'), 
        'date' => '2022-01-01',
        'location' => 'Madrid',
        'user_id' => 1,
        'max_assistants' => 200,
    ];

    $responseUpdate = $this->postJson('/api/events/' . $eventId . '/edit', $updatedEventData);

    if ($responseUpdate->getStatusCode() !== 200) {
        $errorUpdate = $responseUpdate->json();
        var_dump($errorUpdate);
    }
    $responseUpdate->assertStatus(200);
    $responseUpdate->assertJson(['message' => 'Event Updated!']);
}

public function test_show()
    {
        $eventData = [
            'title' => 'Evento de Prueba',
            'category_id' => 1,
            'description' => 'Descripción del evento de prueba',
            'image' => 'https://via.placeholder.com/150',
            'date' => '2021-12-31',
            'location' => 'Barcelona',
            'user_id' => 1
        ];
        $event = Event::create($eventData);

        $response = $this->getJson('/api/events/' . $event->id);

        if ($response->getStatusCode() !== 200) {
            $error = $response->json();
            var_dump($error);
        }


        $response->assertStatus(200);
        $response->assertJson(['data' => $eventData]);
    }



    public function test_destroy()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $eventData = [
            'title' => 'Evento de Prueba',
            'category_id' => 1,
            'description' => 'Descripción del evento de prueba',
            'image' => 'https://via.placeholder.com/150',
            'date' => '2021-12-31',
            'location' => 'Barcelona',
            'user_id' => 1
        ];
        $event = Event::create($eventData);

        $response = $this->deleteJson('/api/events/' . $event->id . '/delete');
        if ($response->getStatusCode() !== 200) {
            $error = $response->json();
            var_dump($error);
        }
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Event deleted OK']);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->getJson('/api/events');
    
        if ($response->getStatusCode() !== 200) {
            $error = $response->json();
            var_dump($error);
        }
    
        $response->assertStatus(200);
    }    
}

