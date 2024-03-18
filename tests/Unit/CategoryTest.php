<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Event;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    // test sobre crear una categoria
    public function testCreateCategory()
    {
        $category = Category::create(['name' => 'no-presencial']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'no-presencial'
        ]);
    }
}