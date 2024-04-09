<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;


class EventSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run()
    {

        // // Crear categorías
        // Category::create(['name' => 'Presencial']);
        // Category::create(['name' => 'Online']);

        // // Crear eventos
        // Event::factory(25)->create([
        //     'category_id' => function () {
        //         // Escoge aleatoriamente entre los ids de las categorías creadas
        //         return Category::pluck('id')->random();
        //     },
        // ]);
    }
}