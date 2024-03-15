<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Event;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCategory()
    {
        $category = Category::create(['name' => 'Test Category']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Test Category'
        ]);
    }

    public function testCategoryEventRelationship()
    {
        // Create a category
        $category = Category::create(['name' => 'Test Category']);

        // Create an event related to the category
        $event = Event::factory()->create(['category_id' => $category->id]);

        // Retrieve events associated with the category
        $events = $category->events;

        // Check if the event is associated with the category
        $this->assertTrue($events->contains($event));
    }
}
