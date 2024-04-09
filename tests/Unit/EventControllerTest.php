<?php 

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;
    
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

