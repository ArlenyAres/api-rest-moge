<?php
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // Check if categories already exist
        // if (Category::count() === 0) {
        //     // Create 'presencial' category
        //     Category::create(['name' => 'presencial']);

        //     // Create 'online' category
        //     Category::create(['name' => 'online']);
        // }
    }
}
?>