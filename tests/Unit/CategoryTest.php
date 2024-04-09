<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Event;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_table_has_two_entries()
    {
        $categoryOnline = Category::where('name', 'Online')->first();
        $categoryPresencial = Category::where('name', 'Presencial')->first();

        $this->assertNotNull($categoryOnline);
        $this->assertNotNull($categoryPresencial);

        $categoriesCount = Category::count();
        $this->assertEquals(2, $categoriesCount);
    }

    public function test_category_has_many_events()
    {
        $category = Category::create(['name' => 'online']);
        $event = Event::create([
            'title' => 'Evento de prueba',
            'description' => 'Descripción del evento de prueba',
            'category_id' => $category->id,
            'date' => '2021-12-31',
            'location' => 'Barcelona',
            'image' => 'https://via.placeholder.com/150',
            'user_id' => 1
        ]);

        $events = $category->events;
        if (!$events->contains($event)) {
            $error = "El evento no está asociado a la categoría correctamente.";
            var_dump($error);
        }

        $this->assertTrue($events->contains($event), "El evento no está asociado a la categoría correctamente.");
    }
}