<?php 

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;

// class EventControllerTest extends TestCase
// {
//     use RefreshDatabase;

//     public function test_store()
//     {
//         $eventData = [
//             'title' => 'Evento de Prueba',
//             'category_id' => 1,
//             'description' => 'Descripción del evento de prueba',
//             'image' => 'https://via.placeholder.com/150',
//             'date' => '2021-12-31',
//             'location' => 'Barcelona',
//             'user_id' => 1

//         ];

//         $response = $this->postJson('/api/events/create', $eventData);
//         if ($response->getStatusCode() !== 201) {
//             $error = $response->json();
//             var_dump($error);
//         }

//         $response->assertStatus(201);
//         $response->assertJson(['message' => 'Event Create!']);

//     }

//     public function test_update()
// {
//     // guardo un evento en esta variable para despues modificarla, es el mismo evento que antes en el test store
//     $eventData = [
//         'title' => 'Evento de Prueba',
//         'category_id' => 1,
//         'description' => 'Descripción del evento de prueba',
//         'image' => 'https://via.placeholder.com/150',
//         'date' => '2021-12-31',
//         'location' => 'Barcelona',
//         'user_id' => 1
//     ];


//     $responseCreate = $this->postJson('/api/events/create', $eventData);
//     if ($responseCreate->getStatusCode() !== 201) {
//         $errorCreate = $responseCreate->json();
//         var_dump($errorCreate);
//     }


//     $responseCreate->assertStatus(201);
//     $responseCreate->assertJson(['message' => 'Event Create!']);

//     $eventId = $responseCreate->json()['data']['id'];

//     $updatedEventData = [
//         'title' => 'Evento Actualizado',
//         'category_id' => 2,
//         'description' => 'Descripción del evento actualizado',
//         'image' => 'https://via.placeholder.com/300',
//         'date' => '2022-01-01',
//         'location' => 'Madrid',
//         'user_id' => 1
//     ];

//     $responseUpdate = $this->putJson('/api/events/' . $eventId . '/edit', $updatedEventData);

//     if ($responseUpdate->getStatusCode() !== 200) {
//         $errorUpdate = $responseUpdate->json();
//         var_dump($errorUpdate);
//     }
//     $responseUpdate->assertStatus(200);

//     // // Verifica que la respuesta contenga el mensaje de éxito
//     // $responseUpdate->assertJson(['message' => 'Event Update!']);
// }



// public function test_show()
//     {
//         $eventData = [
//             'title' => 'Evento de Prueba',
//             'category_id' => 1,
//             'description' => 'Descripción del evento de prueba',
//             'image' => 'https://via.placeholder.com/150',
//             'date' => '2021-12-31',
//             'location' => 'Barcelona',
//             'user_id' => 1
//         ];
//         $event = Event::create($eventData);

//         $response = $this->getJson('/api/events/' . $event->id);

//         if ($response->getStatusCode() !== 200) {
//             $error = $response->json();
//             var_dump($error);
//         }


//         $response->assertStatus(200);
//         $response->assertJson(['data' => $eventData]);
//     }



//     public function test_destroy()
//     {
//         $eventData = [
//             'title' => 'Evento de Prueba',
//             'category_id' => 1,
//             'description' => 'Descripción del evento de prueba',
//             'image' => 'https://via.placeholder.com/150',
//             'date' => '2021-12-31',
//             'location' => 'Barcelona',
//             'user_id' => 1
//         ];
//         $event = Event::create($eventData);

//         $response = $this->deleteJson('/api/events/' . $event->id . '/delete');
//         if ($response->getStatusCode() !== 200) {
//             $error = $response->json();
//             var_dump($error);
//         }
//         $response->assertStatus(200);
//         $response->assertJson(['message' => 'Event deleted OK']);
//         $this->assertDatabaseMissing('events', ['id' => $event->id]);
//     }

//     public function test_index()
//     {
//         $response = $this->getJson('/api/events');

//         if ($response->getStatusCode() !== 200) {
//             $error = $response->json();
//             var_dump($error);
//         }

//         $response->assertStatus(200);
//         $response->assertJsonStructure([
//             'current_page',
//             'data' => [
//                 '*' => [
//                     'id',
//                     'title',
//                     'category_id',
//                     'description',
//                     'image',
//                     'date',
//                     'location',
//                     'user_id',
//                 ]
//             ]
//         ]);
//     }
// }

