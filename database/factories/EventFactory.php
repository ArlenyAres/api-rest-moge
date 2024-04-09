<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'image' => 'https://source.unsplash.com/800x600/?event',
            'location' => $this->faker->address(),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'category_id' => $this->faker->name() === 'Presencial' ? 1 : 2,
            'user_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
